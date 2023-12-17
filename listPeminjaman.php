<?php
session_start();
if ($_SESSION['role'] != 'Mahasiswa') {
    header('location:dataBuku.php?msg=denied-access');
}

include 'header.php';
include 'koneksi.php';

$sql = "SELECT * FROM peminjaman WHERE nim='" . $_SESSION['username'] . "' AND status != 'Sudah Kembali'";
$query = $koneksi->query($sql);
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Peminjaman</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">List Peminjaman</a></li>
                <li class="breadcrumb-item active"><?= $_SESSION['username'] ?></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="col-12">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">List Peminjaman</h5>
                    <table class="table table-borderless datatable">
                        <thead>
                            <tr>
                                <th scope="col">Kode Pinjam</th>
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
                                    <th><?= $gabungJudul ?></th>
                                    <td><?= $gabungKategori ?></td>
                                    <td><?= $data['tgl_pinjam'] ?></td>
                                    <td><?= $data['batas_pinjam'] ?></td>
                                    <td><?= $gabungJumlah ?></td>
                                    <?php
                                    if ($data['status'] == 'Belum Kembali') { ?>
                                        <td><a href="aksiPinjam.php?return=<?= $data['kode_pinjam'] ?>"><button type="submit" class="badge bg-danger-light text-dark">Kembalikan?</button></a></td>
                                    <?php
                                    } elseif ($data['status'] == 'Menunggu') { ?>
                                        <td><button class="badge bg-warning-light text-dark">Waiting</button></td>
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
        </div><!-- End Recent Sales -->
    </section>

</main><!-- End #main -->
<?php
include 'footer.php';
?>