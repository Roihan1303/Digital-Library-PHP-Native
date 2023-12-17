<?php
session_start();
include 'koneksi.php';

if (isset($_GET['editPetugas'])) {
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $sql = "UPDATE petugas SET namaPetugas='$nama' WHERE username='$username';";
    $query = $koneksi->query($sql);
    if ($query) {
        header('location:userProfile.php?msg=edit-data-success');
    }
} elseif (isset($_GET['editMahasiswa'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $jurusan = $_POST['jurusan'];
    $sql = "UPDATE mahasiswa SET namaMhs='$nama',email='$email',jurusan='$jurusan' WHERE nim='$nim';";
    $query = $koneksi->query($sql);
    if ($query) {
        header('location:userProfile.php?msg=edit-data-success');
    }
} elseif (isset($_GET['editPass'])) {
    $username = $_POST['username'];
    $pass = md5($_POST['newpass']);
    $repass = md5($_POST['renewpass']);

    if ($pass != $repass) {
        header('location:userProfile.php?msg=password-different');
    } else {
        if ($_SESSION['role'] == 'Petugas') {
            $sql = "UPDATE petugas SET password='$pass' WHERE username='$username';";
        } else {
            $sql = "UPDATE mahasiswa SET password='$pass' WHERE nim='$username';";
        }
        $query = $koneksi->multi_query($sql);
        if ($query) {
            header('location:userProfile.php?msg=edit-password-success');
        }
    }
} elseif (isset($_GET['hapus'])) {
    $sql = "DELETE FROM mahasiswa WHERE nim='" . $_GET['hapus'] . "'";
    $query = $koneksi->query($sql);
    if ($query) {
        header('location:dataMahasiswa.php?msg=deleted-mahasiswa-success');
    } else {
        echo "Error: " . $sql . "<br><br>" . $koneksi->error;
    }
}
