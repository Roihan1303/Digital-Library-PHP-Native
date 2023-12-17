<?php
include('koneksi.php');
if (!isset($_SESSION['role'])) {
    header('location:login.php?msg=belumLogin');
}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Digital Library</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/uinma_lib.png" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <?php
            if ($_SESSION['role'] == 'Petugas') { ?>
                <a href="dataBuku.php" class="logo d-flex align-items-center">
                    <img src="assets/img/uinma_lib.png" alt="">
                    <span class="d-none d-lg-block">Digital Library</span>
                </a>
            <?php
            } else { ?>
                <a href="book.php" class="logo d-flex align-items-center">
                    <img src="assets/img/uinma_lib.png" alt="">
                    <span class="d-none d-lg-block">Digital Library</span>
                </a>
            <?php
            }
            ?>

            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <!-- KERANJANG -->
                <?php
                if ($_SESSION['role'] == 'Mahasiswa') {
                    $sql = "SELECT * FROM keranjang LEFT JOIN buku ON keranjang.kode_buku=buku.kode_buku LEFT JOIN kategori ON buku.id_kategori=kategori.id_kategori WHERE nim='" . $_SESSION['username'] . "'";
                    $query = $koneksi->query($sql);
                    $jumlahData = mysqli_num_rows($query);
                ?>
                    <li class="nav-item dropdown">

                        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-cart4"></i>
                            <span class="badge bg-danger badge-number"><?= $jumlahData ?></span>
                        </a><!-- End Messages Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                            <li class="dropdown-header">
                                Keranjang | <?= $_SESSION['username'] ?>
                                <a href="detailKeranjang.php"><span class="badge rounded-pill bg-primary p-2 ms-2">View
                                        all</span></a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <?php
                            while ($data = mysqli_fetch_array($query)) { ?>
                                <li class="message-item">
                                    <a href="aksiPinjam.php?rmvKeranjang=<?= $data['kode_buku'] ?>">
                                        <img src="aksiBuku.php?kode=<?= $data['kode_buku'] ?>">
                                        <div>
                                            <h4><?= $data['judul'] ?></h4>
                                            <p><?= $data['kategori'] ?> | Jumlah : <?= $data['jumlah'] ?></p>
                                        </div>
                                        <button type="button" class="btn-close" style="font-size: 30px;"></button>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            <?php
                            }
                            ?>

                            <li class="dropdown-footer">
                                <a href="detailKeranjang.php"><span class="btn btn-primary p-2 ms-2">Pinjam Buku</span></a>
                            </li>

                        </ul><!-- End Messages Dropdown Items -->

                    </li>

                <?php
                }
                ?>

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?= $_SESSION['nama'] ?> </span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?= $_SESSION['nama'] ?></h6>
                            <span><?= $_SESSION['role'] ?></span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="userProfile.php">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="prosesLogout.php">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <?php
            if ($_SESSION['role'] == 'Mahasiswa') {
            ?>
                <li class="nav-heading">Home</li>

                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#book-nav" data-bs-toggle="collapse">
                        <i class="bi bi-book"></i><span>Book</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="book-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="book.php">
                                <i class="bi bi-circle"></i><span>All Book</span>
                            </a>
                        </li>
                        <li>
                            <a href="book.php?kategori=Bisnis">
                                <i class="bi bi-circle"></i><span>Bisnis</span>
                            </a>
                        </li>
                        <li>
                            <a href="book.php?kategori=Design">
                                <i class="bi bi-circle"></i><span>Design</span>
                            </a>
                        </li>
                        <li>
                            <a href="book.php?kategori=Internet">
                                <i class="bi bi-circle"></i><span>Internet</span>
                            </a>
                        </li>
                        <li>
                            <a href="book.php?kategori=Kesehatan dan Olahraga">
                                <i class="bi bi-circle"></i><span>Kesehatan dan Olahraga</span>
                            </a>
                        </li>
                    </ul>
                </li><!-- End Book Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#e_book-nav" data-bs-toggle="collapse" href="bukuFisik.php">
                        <i class="bi bi-book"></i><span>E-Book</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="e_book-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="ebook.php">
                                <i class="bi bi-circle"></i><span>All Book</span>
                            </a>
                        </li>
                        <li>
                            <a href="ebook.php?kategori=Agama">
                                <i class="bi bi-circle"></i><span>Agama</span>
                            </a>
                        </li>
                        <li>
                            <a href="ebook.php?kategori=Budaya">
                                <i class="bi bi-circle"></i><span>Budaya</span>
                            </a>
                        </li>
                        <li>
                            <a href="ebook.php?kategori=Ilmu Pengetahuan">
                                <i class="bi bi-circle"></i><span>Ilmu Pengetahuan</span>
                            </a>
                        </li>
                        <li>
                            <a href="ebook.php?kategori=Teknologi">
                                <i class="bi bi-circle"></i><span>Teknologi</span>
                            </a>
                        </li>
                    </ul>
                </li><!-- End E-Book Nav -->

                <li class="nav-heading">Peminjaman</li>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="listPeminjaman.php">
                        <i class="bi bi-book"></i>
                        <span>List Peminjaman</span>
                    </a>
                </li><!-- End List Peminjaman Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="historiPeminjaman.php">
                        <i class="bi bi-book"></i>
                        <span>Histori Peminjaman</span>
                    </a>
                </li><!-- End Histori Peminjaman Nav -->

                <li class="nav-heading">Users</li>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="userProfile.php">
                        <i class="bi bi-book"></i>
                        <span>Profile</span>
                    </a>
                </li><!-- End List Peminjaman Nav -->
            <?php
            } else {
            ?>
                <li class="nav-heading">Home</li>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="dataBuku.php ">
                        <i class="bi bi-book"></i>
                        <span>Data Buku</span>
                    </a>
                </li><!-- End Data Buku Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="dataMahasiswa.php">
                        <i class="bi bi-book"></i>
                        <span>Data Mahasiswa</span>
                    </a>
                </li><!-- End Data Buku Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="laporanPeminjaman.php">
                        <i class="bi bi-journal-text"></i>
                        <span>Laporan Peminjaman</span>
                    </a>
                </li><!-- End Laporan Peminjaman Nav -->

                <li class="nav-heading">Users</li>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="userProfile.php">
                        <i class="bi bi-person"></i>
                        <span>Profile</span>
                    </a>
                </li><!-- End Profile Page Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="tambahPetugas.php">
                        <i class="bi bi-person-badge"></i>
                        <span>Register Petugas</span>
                    </a>
                </li><!-- End Register Page Nav -->
            <?php
            }
            ?>

        </ul>

    </aside><!-- End Sidebar-->