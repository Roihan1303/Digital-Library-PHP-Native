<?php
session_start();
include 'header.php';
include 'koneksi.php';

$sql = "SELECT * FROM peminjaman LEFT JOIN mahasiswa ON peminjaman.nim=mahasiswa.nim LEFT JOIN petugas ON peminjaman.petugas=petugas.username WHERE kode_pinjam='" . $_GET['kode'] . "'";
$query = $koneksi->query($sql);
$data = mysqli_fetch_array($query);

$tgl_pinjam = $data['tgl_pinjam'];
$batas_pinjam = $data['batas_pinjam'];
$tgl_kembali = date("Y-m-d");

$tgl_pinjamObj = new DateTime($tgl_pinjam);
$batas_pinjamObj = new DateTime($batas_pinjam);
$tgl_kembaliObj = new DateTime($tgl_kembali);

// Menghitung selisih antara tanggal awal dan akhir dalam bentuk interval
$selisih = $tgl_kembaliObj->diff($tgl_pinjamObj);

// Mengambil jumlah hari selisih
$jumlahHari = $selisih->days;

// Menentukan jumlah hari terlambat berdasarkan batas tanggal
$jumlahHariTerlambat = max(0, $jumlahHari - $batas_pinjamObj->diff($tgl_pinjamObj)->days);

// Menghitung total denda berdasarkan jumlah hari terlambat dan nilai denda per hari
$denda = $jumlahHariTerlambat * 2000;
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Detail Peminjaman</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Peminjaman</a></li>
                <li class="breadcrumb-item"><a href="">Detail Peminjaman</a></li>
                <li class="breadcrumb-item active"><?= $_GET['kode'] ?></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="col-12">
            <div class="card top-selling overflow-auto">
                <div class="card-body pb-0">
                    <h5 class="card-title">Detail Peminjaman <span>| <?= $data['nim'] ?></span></h5>
                    <form action="aksiPinjam.php?confirm=<?= $_GET['kode'] ?>" method="post">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" name="nim" value="<?= $data['nim'] ?>" readonly>
                                    <label>NIM</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" name="namaMhs" value="<?= $data['namaMhs'] ?>" readonly>
                                    <label>Nama</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">Buku</th>
                                    <th scope="col">Judul Buku</th>
                                    <th scope="col">Kategori Buku</th>
                                    <th scope="col">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form action="aksiPinjam.php?tambah" method="post">
                                    <?php
                                    $sqlBuku = "SELECT * FROM detail_peminjaman 
                                                    LEFT JOIN buku ON detail_peminjaman.kode_buku=buku.kode_buku
                                                    LEFT JOIN kategori ON buku.id_kategori=kategori.id_kategori
                                                    WHERE kode_pinjam='" . $_GET['kode'] . "'";
                                    $queryBuku = $koneksi->query($sqlBuku);
                                    while ($dataBuku = mysqli_fetch_array($queryBuku)) { ?>
                                        <tr>
                                            <input type="text" name="kodeBuku[]" value="<?= $dataBuku['kode_buku'] ?>" hidden>
                                            <input type="number" name="jumlah[]" value="<?= $dataBuku['jumlah'] ?>" hidden>
                                            <th scope="row"><img src="aksiBuku.php?kode=<?= $dataBuku['kode_buku'] ?>" alt=""></th>
                                            <td><span class="text-primary fw-bold"><?= $dataBuku['judul'] ?></span></td>
                                            <td><?= $dataBuku['kategori'] ?></td>
                                            <td class="fw-bold"><?= $dataBuku['jumlah'] ?></td>
                                        </tr>

                                    <?php
                                    }
                                    ?>
                                </form>
                            </tbody>
                        </table>
                        <hr>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input class="form-control" name="tgl_pinjam" value="<?= $data['tgl_pinjam'] ?>" readonly>
                                    <label>Tanggal Pinjam</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input class="form-control" name="batas_pinjam" value="<?= $data['batas_pinjam'] ?>" readonly>
                                    <label>Batas Pinjam</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input class="form-control" name="tgl_kembali" value="<?= $tgl_kembali ?>" readonly>
                                    <label>Tanggal Kembali</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="denda" value="<?= $denda ?>" readonly>
                                    <label>Denda</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" name="status" value="<?= $data['status'] ?>" readonly>
                                    <label>Status</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <?php
                                    if ($data['petugas'] = 'null') { ?>
                                        <input class="form-control" name="namaPetugas" value="<?= $_SESSION['nama'] ?>" readonly>
                                    <?php
                                    } else { ?>
                                        <input class="form-control" name="namaPetugas" value="<?= $data['namaPetugas'] ?>" readonly>
                                    <?php
                                    }
                                    ?>
                                    <label for="floatingName">Nama Petugas</label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="text-center">
                            <?php
                            if ($_SESSION['role'] == 'Petugas') { ?>
                                <button type="submit" class="btn btn-success">Confirm</button>
                            <?php
                            } else { ?>
                                <button type="button" onclick="window.print()" class="btn btn-success">Download</button>
                            <?php
                            }
                            ?>
                        </div>
                        <br>
                    </form>
                </div>
            </div>
        </div><!-- End Recent Sales -->
    </section>

</main><!-- End #main -->
<?php
include 'footer.php';
?>