<?php
session_start();
include('config.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'Company') {
    header("Location: index.php");
    exit;
}

class Job {
    // Properti-peoperti dari tabel tbljob
    public $JOBID;
    public $COMPANYID;
    public $CATEGORY;
    public $OCCUPATIONTITLE;
    public $SALARIES;
    public $QUALIFICATION_WORKEXPERIENCE;
    public $JOBDESCRIPTION;
    public $PREFEREDSEX;
    public $JOBSTATUS;

    // Metode untuk memasukkan data pekerjaan baru
    public function create() {
        global $conn; // Menggunakan variabel $conn dari file config.php

        $sql = "INSERT INTO tbljob (
                    JOBID, COMPANYID, CATEGORY, OCCUPATIONTITLE, SALARIES,
                    QUALIFICATION_WORKEXPERIENCE, JOBDESCRIPTION, PREFEREDSEX, JOBSTATUS
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, ?
                )";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisssssss", $this->JOBID, $this->COMPANYID, $this->CATEGORY, $this->OCCUPATIONTITLE, 
                         $this->SALARIES, $this->QUALIFICATION_WORKEXPERIENCE, $this->JOBDESCRIPTION, 
                         $this->PREFEREDSEX, $this->JOBSTATUS);
        
        if ($stmt->execute()) {
            return true; // Mengembalikan true jika insert berhasil
        } else {
            return false; // Mengembalikan false jika insert gagal
        }
    }
}


// Fungsi untuk menangani proses insert dari form
function handleInsert() {
    global $conn; // Menggunakan variabel $conn dari file config.php

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
        $job = new Job();
        // Mengisi objek $job dengan data dari form
        $job->JOBID = $_POST['JOBID'];
        $job->COMPANYID = $_POST['COMPANYID'];
        $job->CATEGORY = $_POST['CATEGORY'];
        $job->OCCUPATIONTITLE = $_POST['OCCUPATIONTITLE'];
        $job->SALARIES = $_POST['SALARIES'];
        $job->QUALIFICATION_WORKEXPERIENCE = $_POST['QUALIFICATION_WORKEXPERIENCE'];
        $job->JOBDESCRIPTION = $_POST['JOBDESCRIPTION'];
        $job->PREFEREDSEX = $_POST['PREFEREDSEX'];
        $job->JOBSTATUS = $_POST['JOBSTATUS'];

        // Memanggil metode create() untuk memasukkan data ke dalam tabel
        if ($job->create()) {
            // Redirect ke halaman post_job.php dengan pesan sukses
            header("Location: post_job.php?message=SUCCESS");
            exit;
        } else {
            // Handle jika terjadi error saat insert
            echo "Error inserting job vacancy.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Job</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Company Dashboard</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <input class="form-control form-control-dark w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="logout.php">Sign out</a>
            </div>
        </div>
    </header>
    <div class="container mt-5">
        <h1>Post a Job</h1>
        <form method="POST" action="post_job.php">
            <!-- Form input untuk data pekerjaan -->
            <div class="mb-3">
                <label for="JOBID" class="form-label">Job ID</label>
                <input type="text" class="form-control" id="JOBID" name="JOBID" required>
            </div>
            <div class="mb-3">
                <label for="COMPANYID" class="form-label">Company ID</label>
                <input type="text" class="form-control" id="COMPANYID" name="COMPANYID" required>
            </div>
            <div class="mb-3">
                <label for="CATEGORY" class="form-label">Category</label>
                <input type="text" class="form-control" id="CATEGORY" name="CATEGORY" required>
            </div>
            <div class="mb-3">
                <label for="OCCUPATIONTITLE" class="form-label">Occupation Title</label>
                <input type="text" class="form-control" id="OCCUPATIONTITLE" name="OCCUPATIONTITLE" required>
            </div>
            <div class="mb-3">
                <label for="SALARIES" class="form-label">Salaries</label>
                <input type="text" class="form-control" id="SALARIES" name="SALARIES" required>
            </div>
            <div class="mb-3">
                <label for="QUALIFICATION_WORKEXPERIENCE" class="form-label">Qualifications and Work Experience</label>
                <textarea class="form-control" id="QUALIFICATION_WORKEXPERIENCE" name="QUALIFICATION_WORKEXPERIENCE" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="JOBDESCRIPTION" class="form-label">Job Description</label>
                <textarea class="form-control" id="JOBDESCRIPTION" name="JOBDESCRIPTION" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="PREFEREDSEX" class="form-label">Preferred Sex</label>
                <input type="text" class="form-control" id="PREFEREDSEX" name="PREFEREDSEX" required>
            </div>
            <div class="mb-3">
                <label for="JOBSTATUS" class="form-label">Job Status</label>
                <input type="text" class="form-control" id="JOBSTATUS" name="JOBSTATUS" required>
            </div>
            <!-- Tombol untuk menyimpan form -->
            <button type="submit" name="save" class="btn btn-primary">Post Job</button>
        </form>
    </div>

    <!-- Memuat script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
