<?php
session_start();
include 'koneksi.php';
include 'header.php';

$id = $_SESSION['username'];
$nama = $_SESSION['nama'];
$role = $_SESSION['role'];

$sqlPetugas = "SELECT * FROM petugas WHERE username='$id'";
$queryPetugas = $koneksi->query($sqlPetugas);
$dataPetugas = mysqli_fetch_array($queryPetugas);

$sqlMhs = "SELECT * FROM mahasiswa LEFT JOIN jurusan ON mahasiswa.jurusan=jurusan.id_jur LEFT JOIN fakultas ON jurusan.id_fak=fakultas.id_fak WHERE nim='$id'";
$queryMhs = $koneksi->query($sqlMhs);
$dataMhs = mysqli_fetch_array($queryMhs);
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>User Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Users</li>
                <li class="breadcrumb-item active">Profile</li>
                <li class="breadcrumb-item active"><?= $nama ?></li>
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
                        <h2><?= $nama ?></h2>
                        <h3><?= $role ?></h3>
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
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                    Profile</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2">

                            <!-- Profile Overview Form -->
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">About</h5>
                                <p class="small fst-italic">Hello, My name is <?php if ($role == 'Petugas') {
                                                                                    echo $dataPetugas['namaPetugas'];
                                                                                } else {
                                                                                    echo $dataMhs['namaMhs'];
                                                                                }
                                                                                ?></p>

                                <h5 class="card-title">Profile Details</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Username</div>
                                    <div class="col-lg-9 col-md-8"><?php if ($role == 'Petugas') {
                                                                        echo $dataPetugas['username'];
                                                                    } else {
                                                                        echo $dataMhs['nim'];
                                                                    } ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                    <div class="col-lg-9 col-md-8"><?php if ($role == 'Petugas') {
                                                                        echo $dataPetugas['namaPetugas'];
                                                                    } else {
                                                                        echo $dataMhs['namaMhs'];
                                                                    }
                                                                    ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Faculty</div>
                                    <div class="col-lg-9 col-md-8"><?php if ($role == 'Petugas') {
                                                                        echo '-';
                                                                    } else {
                                                                        echo $dataMhs['nama_fak'];
                                                                    } ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Major</div>
                                    <div class="col-lg-9 col-md-8"><?php if ($role == 'Petugas') {
                                                                        echo '-';
                                                                    } else {
                                                                        echo $dataMhs['nama_jur'];
                                                                    } ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8"><?php if ($role == 'Petugas') {
                                                                        echo '-';
                                                                    } else {
                                                                        echo $dataMhs['email'];
                                                                    } ?></div>
                                </div>

                            </div>

                            <!-- Profile Edit Form -->
                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                <!-- FORM PETUGAS -->
                                <?php if ($role == 'Petugas') { ?>
                                    <form action="aksiUser.php?editPetugas" method="post">
                                        <div class="row mb-3">
                                            <label class="col-md-4 col-lg-3 col-form-label">Username</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="username" type="text" class="form-control" value="<?= $dataPetugas['username'] ?>" hidden>
                                                <input type="text" class="form-control" value="<?= $dataPetugas['username'] ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="nama" type="text" class="form-control" value="<?= $dataPetugas['namaPetugas'] ?>">
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                <?php } else { ?>
                                    <!-- FORM MAHASISWA -->
                                    <form action="aksiUser.php?editMahasiswa" method="post">
                                        <div class="row mb-3">
                                            <label class="col-md-4 col-lg-3 col-form-label">Username</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="nim" type="text" class="form-control" value="<?= $dataMhs['nim'] ?>" hidden>
                                                <input type="text" class="form-control" value="<?= $dataMhs['nim'] ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="nama" type="text" class="form-control" value="<?= $dataMhs['namaMhs'] ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-4 col-lg-3 col-form-label">Faculty</label>
                                            <div class="col-md-8 col-lg-9">
                                                <select class="form-select" id="fakultas" name="fakultas" required>
                                                    <option selected hidden value=""><?= $dataMhs['nama_fak'] ?></option>
                                                    <option value=""><?= $dataMhs['nama_fak'] ?></option>
                                                    <option value=""><?= $dataMhs['nama_fak'] ?></option>
                                                    <br>
                                                    <option disabled value="">TES</option>
                                                    <option value=""><?= $dataMhs['nama_fak'] ?></option>
                                                    <option value=""><?= $dataMhs['nama_fak'] ?></option>
                                                    <!-- <?php
                                                            $sql2 = "SELECT * FROM fakultas";
                                                            $query2 = $koneksi->query($sql2);
                                                            for ($i = 0; $i < mysqli_num_rows($query2) - 1; $i++) {
                                                                $data2 = mysqli_fetch_array($query2);
                                                                echo "<option value=" . $data2['id_fak'] . ">" . $data2['nama_fak'] . "</option>";
                                                            }
                                                            ?> -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-4 col-lg-3 col-form-label">Major</label>
                                            <div class="col-md-8 col-lg-9">
                                                <select class="form-select" id="jurusan" name="jurusan" required>
                                                    <option selected disabled value=""><?= $dataMhs['nama_jur'] ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="email" type="text" class="form-control" value="<?= $dataMhs['email'] ?>">
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                <?php } ?>

                            </div><!-- End Profile Edit Form -->

                            <!-- Change Password Form -->
                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <form action="aksiUser.php?editPass" method="post">
                                    <input type="text" name="username" value="<?= $id ?>" hidden>

                                    <div class="row mb-3">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="newpass" type="password" class="form-control" id="newPassword">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="renewpass" type="password" class="form-control" id="renewPassword">
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </form>

                            </div><!-- End Change Password Form -->

                        </div><!-- End Bordered Tabs -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert -->
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <?php
            if (isset($_GET['msg'])) {
                if ($_GET['msg'] == 'password-different') { ?>
                    <div id="liveToast" class="alert alert-danger alert-dismissible fade show" role="alert" aria-live="assertive" aria-atomic="true">
                        <i class="bi bi-info-circle me-1"></i>
                        Password Tidak Sama
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                } elseif ($_GET['msg'] == 'edit-data-success') { ?>
                    <div id="liveToast" class="alert alert-info alert-dismissible fade show" role="alert" aria-live="assertive" aria-atomic="true">
                        <i class="bi bi-info-circle me-1"></i>
                        Ubah Data Berhasil
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                } elseif ($_GET['msg'] == 'edit-password-success') { ?>
                    <div id="liveToast" class="alert alert-info alert-dismissible fade show" role="alert" aria-live="assertive" aria-atomic="true">
                        <i class="bi bi-info-circle me-1"></i>
                        Ubah Password Berhasil
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </section>

</main>

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
?>

<script>
    const toastLiveExample = document.getElementById('liveToast')
    const toast = new bootstrap.Toast(toastLiveExample)
    toast.show()
</script>