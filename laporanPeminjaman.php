<?php
session_start();
if ($_SESSION['role'] != 'Petugas') {
    header('location:book.php?msg=denied-access');
}

include 'header.php';
include 'koneksi.php';

$sql = "SELECT * FROM peminjaman LEFT JOIN mahasiswa ON peminjaman.nim=mahasiswa.nim WHERE status!='Menunggu'";
$query = $koneksi->query($sql);

$sql2 = "SELECT * FROM peminjaman LEFT JOIN mahasiswa ON peminjaman.nim=mahasiswa.nim WHERE status='Menunggu'";
$query2 = $koneksi->query($sql2);
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Laporan Peminjaman</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item active">Laporan Peminjaman</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">

        <!-- Laporan Peminjaman -->
        <div class="col-12">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">Laporan Peminjaman</h5>
                    <table class="table table-borderless datatable">
                        <thead>
                            <tr>
                                <th scope="col">Kode Pinjam</th>
                                <th scope="col">NIM</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Judul Buku</th>
                                <th scope="col">Kategori Buku</th>
                                <th scope="col">Tanggal Peminjaman</th>
                                <th scope="col">Batas Peminjaman</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($data = mysqli_fetch_array($query)) {
                                $sqlBuku = "SELECT judul,kategori,jumlah FROM detail_peminjaman 
                                                                        LEFT JOIN buku ON detail_peminjaman.kode_buku=buku.kode_buku
                                                                        LEFT JOIN kategori ON buku.id_kategori=kategori.id_kategori 
                                                                        WHERE kode_pinjam='" . $data['kode_pinjam'] . "'";
                                $queryBuku = $koneksi->query($sqlBuku);
                                if ($queryBuku) {
                                    $judul = array();
                                    $kategori = array();
                                    $jumlah = array();

                                    while ($dataBuku = mysqli_fetch_array($queryBuku)) {
                                        $judul[] = '• ' . $dataBuku['judul'];
                                        $kategori[] = '• ' . $dataBuku['kategori'];
                                        $jumlah[] = '• ' . $dataBuku['jumlah'];
                                    }

                                    $gabungJudul = implode('<br>', $judul);
                                    $gabungKategori = implode('<br>', $kategori);
                                    $gabungJumlah = implode('<br>', $jumlah);
                                }
                            ?>

                                <tr>
                                    <th><?= $data['kode_pinjam'] ?></th>
                                    <th><?= $data['nim'] ?></th>
                                    <th><?= $data['namaMhs'] ?></th>
                                    <th><?= $gabungJudul ?></th>
                                    <td><?= $gabungKategori ?></td>
                                    <td><?= $data['tgl_pinjam'] ?></td>
                                    <td><?= $data['batas_pinjam'] ?></td>
                                    <td><?= $gabungJumlah ?></td>
                                    <?php
                                    if ($data['status'] == 'Belum Kembali') { ?>
                                        <td><button type="submit" class="badge bg-danger-light text-dark">Belum Kembali</button></td>
                                    <?php
                                    } elseif ($data['status'] == 'Sudah Kembali') { ?>
                                        <td><button type="submit" class="badge bg-success-light text-dark">Sudah Kembali</button></td>
                                    <?php
                                    }
                                    ?>
                                </tr>

                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Konfirmasi Pengembalian -->
        <div class="col-12">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">Konfirmasi Pengembalian</h5>
                    <table class="table table-borderless datatable">
                        <thead>
                            <tr>
                                <th scope="col">Kode Pinjam</th>
                                <th scope="col">NIM</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Judul Buku</th>
                                <th scope="col">Kategori Buku</th>
                                <th scope="col">Tanggal Peminjaman</th>
                                <th scope="col">Batas Peminjaman</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($data = mysqli_fetch_array($query2)) {
                                $sqlBuku = "SELECT judul,kategori,jumlah FROM detail_peminjaman 
                                                                        LEFT JOIN buku ON detail_peminjaman.kode_buku=buku.kode_buku
                                                                        LEFT JOIN kategori ON buku.id_kategori=kategori.id_kategori 
                                                                        WHERE kode_pinjam='" . $data['kode_pinjam'] . "'";
                                $queryBuku = $koneksi->query($sqlBuku);
                                if ($queryBuku) {
                                    $judul = array();
                                    $kategori = array();
                                    $jumlah = array();

                                    while ($dataBuku = mysqli_fetch_array($queryBuku)) {
                                        $judul[] = '• ' . $dataBuku['judul'];
                                        $kategori[] = '• ' . $dataBuku['kategori'];
                                        $jumlah[] = '• ' . $dataBuku['jumlah'];
                                    }

                                    $gabungJudul = implode('<br>', $judul);
                                    $gabungKategori = implode('<br>', $kategori);
                                    $gabungJumlah = implode('<br>', $jumlah);
                                }
                            ?>
                                <tr>
                                    <th><?= $data['kode_pinjam'] ?></th>
                                    <th><?= $data['nim'] ?></th>
                                    <th><?= $data['namaMhs'] ?></th>
                                    <th><?= $gabungJudul ?></th>
                                    <td><?= $gabungKategori ?></td>
                                    <td><?= $data['tgl_pinjam'] ?></td>
                                    <td><?= $data['batas_pinjam'] ?></td>
                                    <td><?= $gabungJumlah ?></td>
                                    <?php
                                    if ($data['status'] == 'Menunggu') { ?>
                                        <td>
                                            <button class="badge bg-warning-light text-dark">Waiting</button>
                                            <a href="detailPeminjaman.php?kode=<?= $data['kode_pinjam'] ?>"><button class="badge bg-success-light text-dark">Detail</button></a>
                                        </td>
                                    <?php
                                    }
                                    ?>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Alert -->
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <?php
            if (isset($_GET['msg'])) {
                if ($_GET['msg'] == 'confirm-success') { ?>
                    <div id="liveToast" class="alert alert-info alert-dismissible fade show" role="alert" aria-live="assertive" aria-atomic="true">
                        <i class="bi bi-info-circle me-1"></i>
                        Konfirmasi Pengembalian Buku Berhasil
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