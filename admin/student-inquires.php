<?php
session_start();
include('../includes/dbconn.php');
include('../includes/check-login.php');
check_login();

// Handle "Done" button click
if (isset($_POST['done'])) {
    $inquireRegNo = $_POST['regno'];
    $postingDate  = $_POST['posting_date'];

    // Delete the inquiry based on Reg No and Posting Date
    $stmtDelete = $mysqli->prepare("DELETE FROM inquire WHERE regno = ? AND posting_date = ?");
    $stmtDelete->bind_param("ss", $inquireRegNo, $postingDate);
    $stmtDelete->execute();
    $stmtDelete->close();

    // Redirect to refresh the page
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch all student inquiries
$query = "SELECT regno, posting_date, firstname, room_no, inquire FROM inquire ORDER BY posting_date DESC";
$result = $mysqli->query($query);

if (!$result) {
    die("Query failed: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hostel Management System - Student Inquiries</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <link href="../dist/css/style.min.css" rel="stylesheet">

    <style>
        .card { border: none; border-radius: 1rem; box-shadow: 0 4px 8px rgba(0,0,0,0.05);}
        .card:hover { transform: translateY(-3px); box-shadow: 0 6px 16px rgba(0,0,0,0.1);}
        .card-header { border-bottom: none; background: transparent;}
        table { width: 100%; border-collapse: collapse;}
        table th, table td { padding: 12px; border: 1px solid #e7ebf4; text-align: left;}
        table th { background-color: #e7ebf4; font-weight: normal;}
        .btn-done { background-color: #0056b3; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;}
        .btn-done:hover { background-color: #0056b3;}
        .debug { color: #002651; text-align: center; font-weight: normal; }
    </style>
</head>
<body>
<div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6"
     data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed"
     data-boxed-layout="full">

    <!-- Navbar -->
    <header class="topbar" data-navbarbg="skin6">
        <?php include __DIR__ . '/includes/navigation.php'; ?>
    </header>

    <!-- Sidebar -->
    <aside class="left-sidebar" data-sidebarbg="skin6">
        <div class="scroll-sidebar" data-sidebarbg="skin6">
            <?php include __DIR__ . '/includes/sidebar.php'; ?>
        </div>
    </aside>

    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 align-self-center">
                    <h2 class="mb-0 font-weight-bold mt-2">Student Inquiries</h2>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h4 class="mb-0 font-weight-bold mt-2">All Student Inquiries</h4>
                </div>
                <div class="card-body">

                    <?php
                    if ($result->num_rows > 0) {
                        echo "<table>
                                <thead>
                                    <tr>
                                        <th>Reg No</th>
                                        <th>Posting Date</th>
                                        <th>First Name</th>
                                        <th>Room No</th>
                                        <th>Inquiry</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>";

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['regno']) . "</td>
                                    <td>" . htmlspecialchars($row['posting_date']) . "</td>
                                    <td>" . htmlspecialchars($row['firstname']) . "</td>
                                    <td>" . htmlspecialchars($row['room_no']) . "</td>
                                    <td>" . nl2br(htmlspecialchars($row['inquire'])) . "</td>
                                    <td>
                                        <form method='POST' style='margin:0;'>
                                            <input type='hidden' name='regno' value='" . htmlspecialchars($row['regno']) . "'>
                                            <input type='hidden' name='posting_date' value='" . htmlspecialchars($row['posting_date']) . "'>
                                            <button type='submit' name='done' class='btn-done'>Done</button>
                                        </form>
                                    </td>
                                  </tr>";
                        }

                        echo "</tbody></table>";
                    } else {
                        echo "<p class='debug'>No inquiries have been submitted by students.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php include '../includes/footer.php'; ?>
    </div>
</div>

<script src="../assets/libs/jquery/dist/jquery.min.js"></script>
<script src="../assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../dist/js/app-style-switcher.js"></script>
<script src="../dist/js/feather.min.js"></script>
<script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
<script src="../dist/js/sidebarmenu.js"></script>
<script src="../dist/js/custom.min.js"></script>
</body>
</html>
