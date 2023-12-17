<?php
session_start();
if ($_SESSION['role'] != 'Petugas') {
    header('location:book.php?msg=denied-access');
}

include('header.php');
include 'koneksi.php';

$sql = "SELECT max(kode_buku) as kode FROM buku";
$query = $koneksi->query($sql);
$data = mysqli_fetch_array($query);
$kodeBuku = $data['kode'];

// mengambil angka dari kode barang terbesar, menggunakan fungsi substr dan diubah ke integer dengan (int)
$urutan = (int) substr($kodeBuku, 3, 3);

// bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
$urutan++;

// membentuk kode barang baru
// perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
// misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
// angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG 
$huruf = "BUK";
$kodeBuku = $huruf . sprintf("%02s", $urutan);
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data Buku</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Data Buku</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">

        <div class="col-12">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">Data Buku</h5>

                    <!-- Modal Tambah Buku -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#test">
                        Tambah Buku
                    </button>
                    <div class="modal fade" id="test" tabindex="-1">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Buku</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <ul class="nav nav-tabs nav-tabs-bordered d-flex">
                                        <li class="nav-item flex-fill" role="presentation">
                                            <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#book" type="button" role="tab" aria-selected="true">Book</button>
                                        </li>
                                        <li class="nav-item flex-fill">
                                            <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#e-book" type="button" role="tab" aria-selected="false" tabindex="-1">E-Book</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <!-- BOOK -->
                                        <div class="tab-pane fade active show" id="book" role="tabpanel">
                                            <form action="aksiBuku.php?tambah" method="post" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <label class="col-sm-3 col-form-label">Kode Buku</label>
                                                        <div class="col">
                                                            <input type="text" class="form-control" name="kode" value="<?= $kodeBuku ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-3 col-form-label">Judul Buku</label>
                                                        <div class="col">
                                                            <input type="text" class="form-control" name="judul" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-3 col-form-label">Penulis</label>
                                                        <div class="col">
                                                            <input type="text" class="form-control" name="penulis" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-3 col-form-label">Halaman</label>
                                                        <div class="col">
                                                            <input type="number" class="form-control" name="halaman" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-3 col-form-label">Jenis Buku</label>
                                                        <div class="col">
                                                            <input type="text" class="form-control" name="jenis" value="Book" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-3 col-form-label">Kategori Buku</label>
                                                        <div class="col">
                                                            <select class="form-select" name="kategori" required>
                                                                <option selected disabled value="">Choose...</option>
                                                                <?php
                                                                $sql = "SELECT * FROM kategori";
                                                                $query = $koneksi->query($sql);
                                                                while ($data = mysqli_fetch_array($query)) {
                                                                ?>
                                                                    <option value="<?= $data['id_kategori'] ?>">
                                                                        <?= $data['kategori']; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-3 col-form-label">Deskripsi</label>
                                                        <div class="col">
                                                            <textarea type="text" class="form-control" name="deskripsi" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-3 col-form-label">Stok</label>
                                                        <div class="col">
                                                            <input type="number" class="form-control" name="stok" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-3 col-form-label">Cover <span style="font-size: 10px;">(jpg,png)</span></label>
                                                        <div class="col">
                                                            <input type="file" class="form-control" name="cover" accept="image/*" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- E-BOOK -->
                                        <div class="tab-pane fade" id="e-book" role="tabpanel">
                                            <form action="aksiBuku.php?tambah" method="post" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <label class="col-sm-3 col-form-label">Kode Buku</label>
                                                        <div class="col">
                                                            <input type="text" class="form-control" name="kode" value="<?= $kodeBuku ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-3 col-form-label">Judul Buku</label>
                                                        <div class="col">
                                                            <input type="text" class="form-control" name="judul" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-3 col-form-label">Penulis</label>
                                                        <div class="col">
                                                            <input type="text" class="form-control" name="penulis" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-3 col-form-label">Halaman</label>
                                                        <div class="col">
                                                            <input type="number" class="form-control" name="halaman" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-3 col-form-label">Jenis Buku</label>
                                                        <div class="col">
                                                            <input type="text" class="form-control" name="jenis" value="E-Book" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-3 col-form-label">Kategori Buku</label>
                                                        <div class="col">
                                                            <select class="form-select" name="kategori" required>
                                                                <option selected disabled value="">Choose...</option>
                                                                <?php
                                                                $sql = "SELECT * FROM kategori";
                                                                $query = $koneksi->query($sql);
                                                                while ($data = mysqli_fetch_array($query)) {
                                                                ?>
                                                                    <option value="<?= $data['id_kategori'] ?>">
                                                                        <?= $data['kategori']; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-3 col-form-label">Deskripsi</label>
                                                        <div class="col">
                                                            <textarea type="text" class="form-control" name="deskripsi" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-3 col-form-label">Cover <span style="font-size: 10px;">(jpg,png)</span></label>
                                                        <div class="col">
                                                            <input type="file" class="form-control" name="cover" accept="image/*" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-3 col-form-label">File E-Book <span style="font-size: 10px;">(pdf)</span></label>
                                                        <div class="col">
                                                            <input type="file" class="form-control" name="file" accept="application/pdf" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div><!-- End Modal Tambah Buku-->

                    <table class="table table-borderless datatable">
                        <thead>
                            <tr>
                                <th scope="col">Kode Buku</th>
                                <th scope="col">Judul Buku</th>
                                <th scope="col">Jenis Buku</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sqlBuku = "SELECT * FROM buku LEFT JOIN kategori ON buku.id_kategori=kategori.id_kategori";
                            $queryBuku = $koneksi->query($sqlBuku);
                            while ($dataBuku = mysqli_fetch_array($queryBuku)) {
                                echo "<tr>";
                                echo "<th>" . $dataBuku['kode_buku'] . "</th>";
                                echo "<td>" . $dataBuku['judul'] . "</td>";
                                echo "<td>" . $dataBuku['jenis'] . "</td>";
                                echo "<td>" . $dataBuku['kategori'] . "</td>";
                                echo "<td>" . $dataBuku['stok'] . "</td>";
                                echo "<td><a href=\"detailBuku.php?kode=" . $dataBuku['kode_buku'] . "\"><span class=\"badge bg-success\">Info</span></a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- End Recent Sales -->

        <!-- ALERT -->
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <?php
            if (isset($_GET['msg'])) {
                if ($_GET['msg'] == 'denied-access') { ?>
                    <div id="liveToast" class="alert alert-danger alert-dismissible fade show" role="alert" aria-live="assertive" aria-atomic="true">
                        <i class="bi bi-info-circle me-1"></i>
                        Akses Ditolak
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                } elseif ($_GET['msg'] == 'register-book-failed') { ?>
                    <div id="liveToast" class="alert alert-danger alert-dismissible fade show" role="alert" aria-live="assertive" aria-atomic="true">
                        <i class="bi bi-info-circle me-1"></i>
                        Buku Gagal Ditambahkan
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                } elseif ($_GET['msg'] == 'edit-file-failed') { ?>
                    <div id="liveToast" class="alert alert-danger alert-dismissible fade show" role="alert" aria-live="assertive" aria-atomic="true">
                        <i class="bi bi-info-circle me-1"></i>
                        File Gagal Diupdate
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                } elseif ($_GET['msg'] == 'register-petugas-success') { ?>
                    <div id="liveToast" class="alert alert-info alert-dismissible fade show" role="alert" aria-live="assertive" aria-atomic="true">
                        <i class="bi bi-info-circle me-1"></i>
                        Petugas Berhasil Ditambahkan
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                } elseif ($_GET['msg'] == 'register-book-success') { ?>
                    <div id="liveToast" class="alert alert-info alert-dismissible fade show" role="alert" aria-live="assertive" aria-atomic="true">
                        <i class="bi bi-info-circle me-1"></i>
                        Buku Berhasil Ditambahkan
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                } elseif ($_GET['msg'] == 'deleted-book-success') { ?>
                    <div id="liveToast" class="alert alert-info alert-dismissible fade show" role="alert" aria-live="assertive" aria-atomic="true">
                        <i class="bi bi-info-circle me-1"></i>
                        Buku Berhasil Dihapus
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                } elseif ($_GET['msg'] == 'edit-stok-success') { ?>
                    <div id="liveToast" class="alert alert-info alert-dismissible fade show" role="alert" aria-live="assertive" aria-atomic="true">
                        <i class="bi bi-info-circle me-1"></i>
                        Stok Berhasil Diupdate
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                } elseif ($_GET['msg'] == 'edit-file-success') { ?>
                    <div id="liveToast" class="alert alert-info alert-dismissible fade show" role="alert" aria-live="assertive" aria-atomic="true">
                        <i class="bi bi-info-circle me-1"></i>
                        File Berhasil Diupdate
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                }
            } else { ?>
                <div id="liveToast" class="alert alert-info alert-dismissible fade show" role="alert" aria-live="assertive" aria-atomic="true">
                    <i class="bi bi-info-circle me-1"></i>
                    Selamat Datang <?= $_SESSION['nama'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            }
            ?>
        </div>

    </section>
</main><!-- End #main -->
<?php
include('footer.php');
?>
<script>
    const toastLiveExample = document.getElementById('liveToast')
    const toast = new bootstrap.Toast(toastLiveExample)
    toast.show()
</script>