<?php
include 'koneksi.php';

if (isset($_GET['tambah'])) {
    $kode = $_POST['kode'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $halaman = $_POST['halaman'];
    $jenis = $_POST['jenis'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];
    $cover_name = $_FILES['cover']['name'];
    $cover_type = $_FILES['cover']['type'];
    $cover_size = $_FILES['cover']['size'];

    $cover_content = addslashes(file_get_contents($_FILES['cover']['tmp_name']));
    if ($jenis == 'Book') {
        $stok = $_POST['stok'];
        if ($cover_size < 10000000) {
            if ($cover_type == 'image/png' || $cover_type == 'image/jpg' || $cover_type == 'image/jpeg') {
                $sql = "INSERT INTO buku VALUES ('$kode','$judul','$penulis','$halaman','$jenis','$kategori','$deskripsi','$stok');";
                $sql .= "INSERT INTO file VALUES ('$  kode','$cover_content','$cover_name','$cover_type','$cover_size');";
            } else {
                header('location:dataBuku.php?msg=register-book-failed');
            }
        } else {
            header('location:dataBuku.php?msg=register-book-failed');
        }
    } else {
        $file_name = $_FILES['file']['name'];
        $file_type = $_FILES['file']['type'];
        $file_size = $_FILES['file']['size'];
        $file_content = addslashes(file_get_contents($_FILES['file']['tmp_name']));
        if ($file_size < 10000000) {
            if ($file_type == 'application/pdf') {
                $sql = "INSERT INTO buku VALUES ('$kode','$judul','$penulis','$halaman','$jenis','$kategori','$deskripsi',null);";
                $sql .= "INSERT INTO file VALUES ('$kode','$cover_content','$cover_name','$cover_type','$cover_size');";
                $sql .= "INSERT INTO file VALUES ('$kode','$file_content','$file_name','$file_type','$file_size');";
            } else {
                header('location:dataBuku.php?msg=register-book-failed');
            }
        } else {
            header('location:dataBuku.php?msg=register-book-failed');
        }
    }

    $query = $koneksi->multi_query($sql);
    if ($query) {
        header('location:dataBuku.php?msg=register-book-success');
    } else {
        echo "Error: " . $sql . "<br><br>" . $koneksi->error;
    }
} elseif (isset($_GET['kode'])) {
    $kode = $_GET['kode'];
    $sql = "SELECT * FROM file WHERE kode_buku = '$kode' AND tipe='image/jpeg'";
    $query = $koneksi->query($sql);

    if (mysqli_num_rows($query) == 1) {
        $data = mysqli_fetch_array($query);
        $file_name = $data['nama'];
        $file_type = $data['tipe'];
        $file_content = $data['file'];

        header("Content-type: $file_type");
        header("Content-Disposition: attachment; filename=$file_name");

        echo $file_content;
    } else {
        echo "Dokumen Tidak Ditemukan";
    }
} elseif (isset($_GET['hapus'])) {
    $sql = "DELETE FROM buku WHERE kode_buku='" . $_GET['hapus'] . "'";
    $query = $koneksi->query($sql);
    if ($query) {
        header('location:dataBuku.php?msg=deleted-book-success');
    } else {
        echo "Error: " . $sql . "<br><br>" . $koneksi->error;
    }
} elseif (isset($_GET['editStok'])) {
    $stok = $_POST['stok'];
    $sql = "UPDATE buku SET stok='$stok' WHERE kode_buku='" . $_GET['editStok'] . "'";
    $query = $koneksi->query($sql);
    if ($query) {
        header('location:dataBuku.php?msg=edit-stok-success');
    } else {
        echo "Error: " . $sql . "<br><br>" . $koneksi->error;
    }
} elseif (isset($_GET['editFile'])) {
    $editFile = $_GET['editFile'];
    $cover_name = $_FILES['cover']['name'];
    $cover_size = $_FILES['cover']['size'];
    $cover_content = addslashes(file_get_contents($_FILES['cover']['tmp_name']));

    $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_content = addslashes(file_get_contents($_FILES['file']['tmp_name']));


    if ($cover_size < 10000000) {
        if ($file_size < 10000000) {
            $sql = "UPDATE file SET file='$cover_content',nama='$cover_name',ukuran='$cover_size' WHERE kode_buku='$editFile' AND tipe='image/jpeg';";
            $sql .= "UPDATE file SET file='$file_content',nama='$file_name',ukuran='$file_size' WHERE kode_buku='$editFile' AND tipe='application/pdf'";
            // echo $sql;
            $query = $koneksi->multi_query($sql);
            if ($query) {
                header('location: databuku.php?msg=edit-file-success');
            } else {
                echo "Error: " . $sql . "<br><br>" . $koneksi->error;
            }
        } else {
            header('location: databuku.php?msg=edit-file-failed');
        }
    } else {
        header('location: databuku.php?msg=edit-file-failed');
    }
} elseif (isset($_GET['download'])) {
    $kode = $_GET['download'];
    $sql = "SELECT * FROM file WHERE kode_buku = '$kode' AND tipe='application/pdf'";
    $query = $koneksi->query($sql);

    if (mysqli_num_rows($query) == 1) {
        $data = mysqli_fetch_array($query);
        $file_name = $data['nama'];
        $file_type = $data['tipe'];
        $file_content = $data['file'];

        header("Content-type: $file_type");
        header("Content-Disposition: attachment; filename=$file_name");

        echo $file_content;
    } else {
        echo "Dokumen Tidak Ditemukan";
    }
}
