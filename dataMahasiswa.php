<?php
session_start();
if ($_SESSION['role'] != 'Petugas') {
    header('location:book.php?msg=denied-access');
}

include 'header.php';
include 'koneksi.php';

?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data Mahasiswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Data Mahasiswa</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">

        <div class="col-12">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">Data Mahasiswa</h5>

                    <!-- Basic Modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahMahasiswa">
                        Tambah Mahasiswa
                    </button>
                    <div class="modal fade" id="tambahMahasiswa" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Buku</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <form action="prosesRegister.php?mahasiswa" method="post">
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">NIM</label>
                                            <div class="col">
                                                <input type="text" name="nim" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                                            <div class="col">
                                                <input type="text" name="nama" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Password</label>
                                            <div class="col">
                                                <input type="password" name="password" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Ulangi Password</label>
                                            <div class="col">
                                                <input type="password" name="re-password" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Email</label>
                                            <div class="col">
                                                <input type="email" name="email" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Fakultas</label>
                                            <div class="col">
                                                <select class="form-select" id="fakultas" name="fakultas" required>
                                                    <option selected disabled value="">Choose...</option>
                                                    <?php
                                                    $sql = "SELECT * FROM fakultas";
                                                    $query = $koneksi->query($sql);
                                                    for ($i = 0; $i < mysqli_num_rows($query); $i++) {
                                                        $data = mysqli_fetch_array($query);
                                                        echo "<option value=" . $data['id_fak'] . ">" . $data['nama_fak'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Jurusan</label>
                                            <div class="col">
                                                <select class="form-select" id="jurusan" name="jurusan" required>
                                                    <option selected disabled value="">Choose...</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div><!-- End Basic Modal-->

                    <table class="table table-borderless datatable">
                        <thead>
                            <tr>
                                <th scope="col">NIM</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Fakultas</th>
                                <th scope="col">Jurusan</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM mahasiswa LEFT JOIN jurusan ON mahasiswa.jurusan=jurusan.id_jur LEFT JOIN fakultas ON jurusan.id_fak=fakultas.id_fak";
                            $query = $koneksi->query($sql);
                            if (mysqli_num_rows($query) > 0) {
                                while ($data = mysqli_fetch_array($query)) {
                                    echo "<tr>";
                                    echo "<th>" . $data['nim'] . "</th>";
                                    echo "<td>" . $data['namaMhs'] . "</td>";
                                    echo "<td>" . $data['nama_fak'] . "</td>";
                                    echo "<td>" . $data['nama_jur'] . "</td>";
                                    echo "<td><a href=\"profileMahasiswa.php?id=" . $data['nim'] . "\"><span class=\"badge bg-success\">Info</span></a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr>";
                                echo "<th>Data Kosong</th>";
                                echo "</tr>";
                            }
                            ?>
                            <th colspan="5"></th>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- End Recent Sales -->
        <?php
        if (isset($_GET['msg'])) {
            if ($_GET['msg'] == 'registerSuccess') { ?>
                <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                    <div id="liveToast" class   ="alert alert-info alert-dismissible fade show" role="alert" aria-live="assertive" aria-atomic="true">
                        <i class="bi bi-info-circle me-1"></i>
                        Mahasiswa Berhasil Ditambah
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            <?php
            } elseif ($_GET['msg'] == 'deleted-mahasiswa-success') { ?>
                <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                    <div id="liveToast" class="alert alert-info alert-dismissible fade show" role="alert" aria-live="assertive" aria-atomic="true">
                        <i class="bi bi-info-circle me-1"></i>
                        Mahasiswa Berhasil Dihapus
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            <?php
            } elseif ($_GET['msg'] == 'registerFailed') { ?>
                <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                    <div id="liveToast" class="alert alert-danger alert-dismissible fade show" role="alert" aria-live="assertive" aria-atomic="true">
                        <i class="bi bi-exclamation-octagon me-1"></i>
                        Password Salah
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
        <?php
            }
        }
        ?>

    </section>

</main><!-- End #main -->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
    $('#fakultas').change(function() {
        var fakultas = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'ajaxJurusan.php',
            data: 'id_fak=' + fakultas,
            success: function(response) {
                $('#jurusan').html(response);
            }
        });
    });
</script>

<?php
include('footer.php');
?>

<script>
    const toastLiveExample = document.getElementById('liveToast')
    const toast = new bootstrap.Toast(toastLiveExample)
    toast.show()
</script>