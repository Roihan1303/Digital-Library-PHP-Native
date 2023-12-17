<?php
session_start();
include 'koneksi.php';
include 'header.php';

$sql = "SELECT * FROM buku LEFT JOIN kategori ON buku.id_kategori=kategori.id_kategori WHERE kode_buku='" . $_GET['kode'] . "'";
$query = $koneksi->query($sql);
$data = mysqli_fetch_array($query);

$tgl_pinjam = date("Y-m-d");
$timestampForGivenDate = strtotime($tgl_pinjam);
$batas = date('Y-m-d', strtotime('+7 day', $timestampForGivenDate));
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Detail Buku</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active"><?= $data['jenis'] ?></li>
                <li class="breadcrumb-item active"><?= $data['judul'] ?></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <img src="aksiBuku.php?kode=<?= $_GET['kode'] ?>" alt=" <?= $data['judul'] ?>" class="rounded-circle">
                        <h2 style="text-align: center;"><?= $data['judul'] ?></h2>
                        <h3><?= $data['jenis'] ?></h3>
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#book-overview">Overview</button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2">

                            <!-- Book Profile Form -->
                            <div class="tab-pane fade show active profile-overview" id="book-overview">
                                <h5 class="card-title">About Book</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Judul</div>
                                    <div class="col-lg-9 col-md-8"><?= $data['judul'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Penulis</div>
                                    <div class="col-lg-9 col-md-8"><?= $data['penulis'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Halaman</div>
                                    <div class="col-lg-9 col-md-8"><?= $data['halaman'] ?> Halaman</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Jenis Buku</div>
                                    <div class="col-lg-9 col-md-8"><?= $data['jenis'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Kategori</div>
                                    <div class="col-lg-9 col-md-8"><?= $data['kategori'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Stok</div>
                                    <div class="col-lg-9 col-md-8"><?= $data['stok'] ?></div>
                                </div>

                                <p class="small fst-italic"><?= $data['deskripsi'] ?></p>

                                <?php
                                if ($_SESSION['role'] == "Mahasiswa") { ?>
                                    <div class="text-center">
                                        <?php
                                        if ($data['jenis'] == 'Book') { ?>
                                            <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#pinjamBuku">Pinjam</button>
                                            <div class="modal fade" id="pinjamBuku" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Peminjaman</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="row g-3" action="aksiPinjam.php?tambahKeranjang" method="post">
                                                                <div class="col-md-6">
                                                                    <div class="form-floating">
                                                                        <input class="form-control" name="nim" value="<?= $_SESSION['username'] ?>" readonly>
                                                                        <label>NIM</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-floating">
                                                                        <input class="form-control" name="nama" value="<?= $_SESSION['nama'] ?>" readonly>
                                                                        <label>Nama</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-floating">
                                                                        <input class="form-control" name="kode_buku" value="<?= $_GET['kode'] ?>" hidden>
                                                                        <input class="form-control" name="stok" value="<?= $data['stok'] ?>" hidden>
                                                                        <input class="form-control" name="" value="<?= $data['judul'] ?>" readonly>
                                                                        <label>Judul Buku</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-floating">
                                                                        <input class="form-control" name="" value="<?= $data['kategori'] ?>" readonly>
                                                                        <label>Kategori Buku</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-floating">
                                                                        <input type="number" class="form-control" name="jumlah" placeholder="Jumalah yang dipinjam">
                                                                        <label for="floatingName">Jumlah</label>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Tambah Ke
                                                                Keranjang</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div><!-- End Vertically centered Modal-->
                                        <?php
                                        } else { ?>
                                            <a href="aksiBuku.php?download=<?= $data['kode_buku'] ?>"><button type="button" class="btn btn-success">Download</button></a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

                <!-- Edit Book -->
                <?php
                if ($_SESSION['role'] == 'Petugas') { ?>
                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#book-edit">Edit
                                        Book</button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">

                                <!-- Book Profile Form -->
                                <div class="tab-pane fade show active profile-overview" id="book-edit">
                                    <h5 class="card-title">Update Buku</h5>
                                    <?php
                                    if ($data['jenis'] == 'E-Book') { ?>
                                        <form action="aksiBuku.php?editFile=<?= $_GET['kode'] ?>" method="post" enctype="multipart/form-data">
                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Cover <span style="font-size: 10px;">(jpg,png)</span></label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="cover" type="file" class="form-control" accept="image/jpeg">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">File <span style="font-size: 10px;">(pdf)</span></label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="file" type="file" class="form-control" accept="application/pdf">
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <a href="aksiBuku.php?hapus=<?= $_GET['kode'] ?>"><button type="button" class="btn btn-danger">Delete Book</button></a>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    <?php
                                    } else { ?>
                                        <form action="aksiBuku.php?editStok=<?= $_GET['kode'] ?>" method="post">
                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Stok</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="stok" type="number" class="form-control" value="<?= $data['stok'] ?>">
                                                </div>
                                            </div>
                                            <div class="text-center">

                                                <a href="aksiBuku.php?hapus=<?= $_GET['kode'] ?>"><button type="button" class="btn btn-danger">Delete Book</button></a>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    <?php
                                    }
                                    ?>
                                </div>

                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>
                <?php
                }
                ?>

            </div>
        </div>

        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <?php
            if (isset($_GET['msg'])) {
                if ($_GET['msg'] == 'stok-habis') { ?>
                    <div id="liveToast" class="alert alert-danger alert-dismissible fade show" role="alert" aria-live="assertive" aria-atomic="true">
                        <i class="bi bi-info-circle me-1"></i>
                        Stok Buku habis
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </section>

</main><!-- End #main -->
<?php
include 'footer.php';
?>

<script>
    const toastLiveExample = document.getElementById('liveToast')
    const toast = new bootstrap.Toast(toastLiveExample)
    toast.show()
</script>