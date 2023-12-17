<?php
session_start();
include('koneksi.php');
$username = $_POST['username'];
$pass = md5($_POST['password']);
$op = $_GET['op'];
$role = $_POST['role'];

if ($op == "in") {
    if ($role == 'Petugas') {
        $sql = "SELECT * FROM petugas where username='$username' AND password='$pass'";
        $query = $koneksi->query($sql);
        if (mysqli_num_rows($query) == 1) {
            $data = $query->fetch_array();
            $_SESSION['username'] = $data['username'];
            $_SESSION['nama'] = $data['namaPetugas'];
            $_SESSION['role'] = $role;
            header("location:dataBuku.php");
        } else {
            header("location:login.php?msg=salah");
        }
    } elseif ($role == 'Mahasiswa') {
        $sql = "SELECT * FROM mahasiswa where nim='$username' AND password='$pass'";
        $query = $koneksi->query($sql);
        if (mysqli_num_rows($query) == 1) {
            $data = $query->fetch_array();
            $_SESSION['username'] = $data['nim'];
            $_SESSION['nama'] = $data['namaMhs'];
            $_SESSION['role'] = $role;
            header("location:book.php");
        } else {
            header("location:login.php?msg=salah");
        }
    }
} elseif ($op == "out") {
    session_destroy();
    header("location:login.php");
}
