<?php
session_start();
include('config_employee.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'Company') {
    header("Location: index.php");
    exit;
}

 // Assuming this session variable holds the company ID

$sql = "SELECT * FROM tblapplicants";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Applicants</title>
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

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="company_dashboard.php">
                                <span data-feather="home"></span>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="post_job.php">
                                <span data-feather="file"></span>
                                Post a Job
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="list_applicants.php">
                                <span data-feather="shopping-cart"></span>
                                List Applicants
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="list_employee.php">
                                <span data-feather="users"></span>
                                List Employee
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="list_companies.php">
                                <span data-feather="users"></span>
                                Companies
                            </a>
                        </li>
                        
                    </ul>
                </ul>
            </div>
        </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"> List Applicants </h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                            <span data-feather="calendar"></span>
                            This week
                        </button>
                    </div>
                </div>

                <div class="container mt-5">
                <table class="table table-striped">
                    <thead>
                <tr>
                    <th>APPLICANT ID</th>
                    <th>Name</th>
                    <th>EMAIL ADDRESS</th>
                    <th>Address</th>
                    <th>CONTAC</th>
                </tr>
                    </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                    <td><?php echo $row['APPLICANTID']; ?></td>
                    <td><?php echo $row['FNAME']; ?></td>
                    <td><?php echo $row['EMAILADDRESS']; ?></td>
                    <td><?php echo $row['ADDRESS']; ?></td>
                    <td><?php echo $row['CONTACTNO']; ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
                </table>
                </div>

                
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
