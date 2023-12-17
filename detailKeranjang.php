<?php
session_start();
if ($_SESSION['role'] != 'Mahasiswa') {
    header('location:dataBuku.php?msg=denied-access');
}

include 'header.php';
include 'koneksi.php';

$sql = "SELECT * FROM keranjang LEFT JOIN buku ON keranjang.kode_buku=buku.kode_buku LEFT JOIN kategori ON buku.id_kategori=kategori.id_kategori WHERE nim='" . $_SESSION['username'] . "'";
$query = $koneksi->query($sql);

$tgl_pinjam = date("Y-m-d");
$timestampForGivenDate = strtotime($tgl_pinjam);
$batas = date('Y-m-d', strtotime('+7 day', $timestampForGivenDate));
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Keranjang</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Peminjaman</a></li>
                <li class="breadcrumb-item"><a href="">Keranjang</a></li>
                <li class="breadcrumb-item active"><?= $_SESSION['username'] ?></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="col-12">
            <div class="card top-selling overflow-auto">
                <div class="card-body pb-0">
                    <h5 class="card-title">Keranjang <span>| <?= $_SESSION['username'] ?></span></h5>
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
                                while ($data = mysqli_fetch_array($query)) { ?>
                                    <tr>
                                        <input type="text" name="kodeBuku[]" value="<?= $data['kode_buku'] ?>" hidden>
                                        <input type="number" name="jumlah[]" value="<?= $data['jumlah'] ?>" hidden>
                                        <th scope="row"><img src="aksiBuku.php?kode=<?= $data['kode_buku'] ?>" alt=""></th>
                                        <td><span class="text-primary fw-bold"><?= $data['judul'] ?></span></td>
                                        <td><?= $data['kategori'] ?></td>
                                        <td class="fw-bold"><?= $data['jumlah'] ?></td>
                                    </tr>

                                <?php
                                }
                                ?>
                                <tr>
                                    <input type="date" name="tgl_pinjam" value="<?= $tgl_pinjam ?>" hidden>
                                    <td colspan="5" class="text-end">Tanggal Peminjaman : <?= $tgl_pinjam ?></td>
                                </tr>
                                <hr>
                                <tr>
                                    <input type="date" name="batas_pinjam" value="<?= $batas ?>" hidden>
                                    <td colspan="5" class="text-end">Tanggal Jatuh Tempo : <?= $batas ?></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-center"><button type="submit" class="btn btn-primary">Pinjam Buku</button></td>
                                </tr>
                            </form>
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