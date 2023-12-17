<?php
include "koneksi.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM file WHERE kode_buku = '$id'";
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
