<?php
include("koneksi.php");
$fakultas = $_POST['id_fak'];
$sql = "SELECT * FROM jurusan WHERE id_fak='$fakultas'";
$query = $koneksi->query($sql);

while ($data = mysqli_fetch_array($query)) {
?>
    <option value="<?= $data['id_jur'] ?>"><?= $data['nama_jur']; ?></option>
<?php
}
?>