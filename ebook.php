<?php
session_start();
if ($_SESSION['role'] != 'Mahasiswa') {
    header('location:dataBuku.php?msg=denied-access');
}

include 'header.php';
include 'koneksi.php';

if (isset($_GET['kategori'])) {
    $kategori = $_GET['kategori'];
    $sql2 = "SELECT * FROM buku LEFT JOIN file ON buku.kode_buku=file.kode_buku 
                                LEFT JOIN kategori ON buku.id_kategori=kategori.id_kategori 
                                WHERE kategori='$kategori' AND tipe='image/jpeg' AND jenis='E-Book'";
    $query2 = $koneksi->query($sql2);
} else {
    $sql = "SELECT * FROM buku LEFT JOIN file ON buku.kode_buku=file.kode_buku WHERE tipe='image/jpeg' AND jenis='E-Book'";
    $query = $koneksi->query($sql);
}

?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Book</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Book</li>
                <?php
                if (isset($_GET['kategori'])) { ?>
                    <li class="breadcrumb-item active">
                        <?php
                        echo $_GET['kategori'];
                        ?>
                    </li>
                <?php
                } else { ?>
                    <li class="breadcrumb-item active">All Book</li>
                <?php
                }
                ?>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row align-items-top">
            <?php
            if (isset($_GET['kategori'])) {
                while ($data2 = mysqli_fetch_array($query2)) {
            ?>
                    <div class="col-lg-3">
                        <!-- Card with an image on top -->
                        <div class="card">
                            <a href="detailBuku.php?kode=<?= $data2['kode_buku'] ?>"><img src="aksiBuku.php?kode=<?= $data2['kode_buku'] ?>" class="card-img-top" alt="..." height="250"></a>
                            <div class="card-body">
                                <h5 class="card-title"><?= $data2['judul'] ?></h5>
                            </div>
                        </div><!-- End Card with an image on top -->
                    </div>
                <?php
                }
            } else {
                while ($data = mysqli_fetch_array($query)) {  ?>
                    <div class="col-lg-3">
                        <!-- Card with an image on top -->
                        <div class="card">
                            <a href="detailBuku.php?kode=<?= $data['kode_buku'] ?>"><img src="aksiBuku.php?kode=<?= $data['kode_buku'] ?>" class="card-img-top" alt="..." height="250"></a>
                            <div class="card-body">
                                <h5 class="card-title"><?= $data['judul'] ?></h5>
                            </div>
                        </div><!-- End Card with an image on top -->
                    </div>
            <?php
                }
            } ?>
        </div>

        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <?php
            if (isset($_GET['msg']) == 'denied-access') { ?>
                <div id="liveToast" class="alert alert-danger alert-dismissible fade show" role="alert" aria-live="assertive" aria-atomic="true">
                    <i class="bi bi-info-circle me-1"></i>
                    Akses Ditolak
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
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
include 'footer.php';
?>
<script>
    const toastLiveExample = document.getElementById('liveToast')
    const toast = new bootstrap.Toast(toastLiveExample)
    toast.show()
</script>