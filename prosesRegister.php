<?php
session_start();
include('koneksi.php');
$username = $_POST['username'];
$nim = $_POST['nim'];
$nama = $_POST['nama'];
$pass = md5($_POST['password']);
$checkPass = md5($_POST['re-password']);
$email = $_POST['email'];
$jurusan = $_POST['jurusan'];

if ($pass != $checkPass) {
    if (isset($_GET['petugas'])) {
        header('location:registerPetugas.php?msg=registerFailed');
    } elseif (isset($_GET['mahasiswa'])) {
        header('location:dataMahasiswa.php?msg=registerFailed');
    } else {
        header('location:register.php?msg=registerFailed');
    }
} else {
    if (isset($_GET['petugas'])) {
        $sql = "INSERT INTO petugas VALUES ('$username','$pass','$nama');";
        $query = $koneksi->query($sql);
        if ($query === TRUE) {
            header('location:dataBuku.php?msg=register-petugas-success');
        } else {
            echo "Error: " . $sql . "<br>" . $koneksi->error;
        }
    } else {
        $sql = "INSERT INTO mahasiswa VALUES ('$nim','$nama','$pass','$email','$jurusan');";
        $query = $koneksi->query($sql);
        if ($query === TRUE) {
            if (isset($_GET['mahasiswa'])) {
                header('location:dataMahasiswa.php?msg=registerSucess');
            } else {
                header('location:login.php?msg=registerSucess');
            }
        } else {
            echo "Error: " . $sql . "<br>" . $koneksi->error;
        }
    }
}
