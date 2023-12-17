<?php
session_start();
include 'koneksi.php';

if (isset($_GET['tambah'])) {
    $kodeBuku = $_POST['kodeBuku'];
    $jumlah = $_POST['jumlah'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $batas_pinjam = $_POST['batas_pinjam'];

    $sqlPinjam = "SELECT max(kode_pinjam) as kode FROM peminjaman";
    $queryPinjam = $koneksi->query($sqlPinjam);
    $dataPinjam = mysqli_fetch_array($queryPinjam);
    $kodePinjam = $dataPinjam['kode'];

    $urutan = (int) substr($kodePinjam, 3, 3);

    $urutan++;

    $huruf = "PJM";
    $kodePinjam = $huruf . sprintf("%02s", $urutan);

    $sql = "DELETE FROM keranjang WHERE nim='" . $_SESSION['user    name'] . "';";
    $sql .= "INSERT INTO peminjaman VALUES ('$kodePinjam','" . $_SESSION['username'] . "','$tgl_pinjam','$batas_pinjam',null,null,'Belum Kembali',null);";
    for ($i = 0; $i < count($kodeBuku); $i++) {
        $kodeBuku2 = $_POST['kodeBuku'][$i];
        $jumlah2 = $_POST['jumlah'][$i];

        $sqlStok = "SELECT stok FROM buku WHERE kode_buku='$kodeBuku2'";
        $queryStok = $koneksi->query($sqlStok);
        $stok = mysqli_fetch_array($queryStok);
        $updateStok = $stok['stok'] - $jumlah2;
        if ($updateStok < 0) {
            header('location:book.php?msg=peminjaman-failed');
        } else {
            $sql .= "INSERT INTO detail_peminjaman VALUES ('$kodePinjam','$kodeBuku2','$jumlah2');";
            $sql .= "UPDATE buku SET stok='$updateStok' WHERE kode_buku='$kodeBuku2';";
        }
    }

    $query = $koneksi->multi_query($sql);
    if ($query) {
        header('location:book.php?msg=peminjaman-success');
    } else {
        header('location:book.php?msg=peminjaman-failed');
    }
} elseif (isset($_GET['tambahKeranjang'])) {
    $nim = $_POST['nim'];
    $kodeBuku = $_POST['kode_buku'];
    $jumlah = $_POST['jumlah'];

    $sqlStok = "SELECT stok FROM buku WHERE kode_buku='$kodeBuku'";
    $queryStok = $koneksi->query($sqlStok);
    $stok = mysqli_fetch_array($queryStok);
    $updateStok = $stok['stok'] - $jumlah;
    if ($updateStok < 0) {
        header('location:detailBuku.php?kode=' . $kodeBuku . '&msg=stok-habis');
    } else {
        $sql = "INSERT INTO keranjang VALUES ('$nim','$kodeBuku','$jumlah')";
        $query = $koneksi->query($sql);
        if ($query) {
            header('location:book.php');
        } else {
            echo $sql;
        }
    }
} elseif (isset($_GET['return'])) {
    $tgl_kembali = date("Y-m-d");
    $sql = "UPDATE peminjaman SET tgl_kembali='$tgl_kembali', status='Menunggu' WHERE kode_pinjam='" . $_GET['return'] . "'";
    $query = $koneksi->query($sql);
    if ($query) {
        header('location:listPeminjaman.php');
    } else {
        echo 'Error' .   $sql;
    }
} elseif (isset($_GET['confirm'])) {
    $tgl_kembali = $_POST['tgl_kembali'];
    $denda = $_POST['denda'];
    $kodeBuku = $_POST['kodeBuku'];
    $jumlah = $_POST['jumlah'];

    $sql = "UPDATE peminjaman SET tgl_kembali='$tgl_kembali',status='Sudah Kembali',denda='$denda',petugas='" . $_SESSION['username'] . "' WHERE kode_pinjam='" . $_GET['confirm'] . "';";

    for ($i = 0; $i < count($kodeBuku); $i++) {
        $kodeBuku2 = $_POST['kodeBuku'][$i];
        $jumlah2 = $_POST['jumlah'][$i];

        $sqlStok = "SELECT stok FROM buku WHERE kode_buku='$kodeBuku2'";
        $queryStok = $koneksi->query($sqlStok);
        $stok = mysqli_fetch_array($queryStok);
        $updateStok = $stok['stok'] + $jumlah2;

        $sql .= "UPDATE buku SET stok='$updateStok' WHERE kode_buku='$kodeBuku2';";
    }

    $query = $koneksi->multi_query($sql);
    if ($query) {
        header('location:laporanPeminjaman.php?msg=confirm-success');
    } else {
        echo $sql;
    }
} elseif (isset($_GET['rmvKeranjang'])) {
    $sql = "DELETE FROM keranjang WHERE nim='" . $_SESSION['username'] . "' AND kode_buku='" . $_GET['rmvKeranjang'] . "'";
    $query = $koneksi->query($sql);
    if ($query) {
        header('location:book.php');
    } else {
        echo $sql;
    }
}
