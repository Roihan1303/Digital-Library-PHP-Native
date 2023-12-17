<?php
$tanggalAwal = "2023-05-15"; // Tanggal awal
$tanggalAkhir = "2023-06-01"; // Tanggal akhir
$tanggalBatas = "2023-06-02"; // Batas tanggal
$dendaPerHari = 5000; // Nilai denda per hari

// Mengubah tanggal awal, tanggal akhir, dan tanggal batas ke objek DateTime
$tanggalAwalObj = new DateTime($tanggalAwal);
$tanggalBatasObj = new DateTime($tanggalBatas);
$tanggalAkhirObj = new DateTime($tanggalAkhir);

// Menghitung selisih antara tanggal awal dan akhir dalam bentuk interval
$selisih = $tanggalAkhirObj->diff($tanggalAwalObj);

// Mengambil jumlah hari selisih
$jumlahHari = $selisih->days;

// Menentukan jumlah hari terlambat berdasarkan batas tanggal
$jumlahHariTerlambat = max(0, $jumlahHari - $tanggalBatasObj->diff($tanggalAwalObj)->days);

// Menghitung total denda berdasarkan jumlah hari terlambat dan nilai denda per hari
$totalDenda = $jumlahHariTerlambat * $dendaPerHari;

// Menampilkan hasil perhitungan denda
echo "Tanggal Awal: " . $tanggalAwal . "<br>";
echo "Tanggal Akhir: " . $tanggalAkhir . "<br>";
echo "Batas Tanggal: " . $tanggalBatas . "<br>";
echo "Jumlah Hari: " . $jumlahHari . "<br>";
echo "Jumlah Hari Terlambat: " . $jumlahHariTerlambat . "<br>";
echo "Denda per Hari: " . $dendaPerHari . "<br>";
echo "Total Denda: " . $totalDenda . "<br>";
