<?php
session_start();
if ($_SESSION['role'] != 'Petugas') {
    header('location:book.php?msg=denied-access');
}

include 'koneksi.php';
include 'header.php';

$sql = "SELECT * FROM mahasiswa LEFT JOIN jurusan ON mahasiswa.jurusan=jurusan.id_jur LEFT JOIN fakultas ON jurusan.id_fak=fakultas.id_fak WHERE nim=" . $_GET['id'] . "";
$query = $koneksi->query($sql);
$data = mysqli_fetch_array($query);
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data Mahasiswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Data Mahasiswa</li>
                <li class="breadcrumb-item active"><?= $_GET['id'] ?></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                        </svg>
                        <h2><?= $data['namaMhs'] ?></h2>
                        <h3>Mahasiswa</h3>
                        <div class="social-links mt-2">
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">About</h5>
                                <p class="small fst-italic">Hello, My name is <?= $data['namaMhs'] ?></p>

                                <h5 class="card-title">Profile Details</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">NIM</div>
                                    <div class="col-lg-9 col-md-8"><?= $data['nim'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                    <div class="col-lg-9 col-md-8"><?= $data['namaMhs'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Faculty</div>
                                    <div class="col-lg-9 col-md-8"><?= $data['nama_fak'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Major</div>
                                    <div class="col-lg-9 col-md-8"><?= $data['nama_jur'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8"><?= $data['email'] ?></div>
                                </div>

                                <div class="text-center">
                                    <a href="aksiUser.php?hapus=<?= $_GET['id'] ?>"><button type="button" class="btn btn-danger">Delete Mahasiswa</button></a>
                                </div>
                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
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
include 'footer.php';
