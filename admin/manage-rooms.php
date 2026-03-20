<?php
session_start();
include('../includes/dbconn.php');
include('../includes/check-login.php');
check_login();

if(isset($_GET['del'])) {
    $id = intval($_GET['del']);
    $adn = "DELETE from rooms where id = ?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Record has been deleted');</script>";
    echo "<script>window.location.href='manage-rooms.php'</script>";
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Hostel Management System</title>

<link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
<link href="../dist/css/style.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
.card { border: none; border-radius: 1rem; transition: transform 0.2s ease, box-shadow 0.2s ease; }
.card:hover { transform: translateY(-3px); box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1); }
.card-header { border-bottom: none; background: #F4F7FC; border-top-left-radius: 1rem; border-top-right-radius: 1rem; }
table thead { background-color: #e7ebf4; }
.actions-cell { white-space: nowrap; }
.btn-action { padding: 6px 12px; font-size: 14px; margin-right: 5px; border-radius: 0.5rem; }
.btn-info { background-color: #0056b3; border-color: #0056b3; }
.btn-danger { background-color: #860000ff; border-color: #860000ff; }
.btn-success-custom { background-color: #0056b3; border-color: #0056b3; color: #F4F7FC; }
.btn-success-custom:hover { background-color: #0056b3; border-color: #0056b3; }
.search-box { margin-bottom: 20px; width: 100%; }
</style>
</head>

<body>
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>

<div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

<header class="topbar" data-navbarbg="skin6">
    <?php include 'includes/navigation.php'?>
</header>

<aside class="left-sidebar" data-sidebarbg="skin6">
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <?php include 'includes/sidebar.php'?>
    </div>
</aside>

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h2 class="mb-0 font-weight-bold mt-2">Room Management</h2>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0 font-weight-bold mt-2">Room Categories</h4>
                <a href="add-rooms.php" class="btn btn-success-custom">
                    <i class="fas fa-plus"></i> Add New Room
                </a>
            </div>
            <div class="card-body">

                <!-- Common Search Bar -->
                <input type="text" class="form-control search-box" id="searchAll" placeholder="Search Rooms...">

                <!--------------------- BOYS TABLE ------------------------>
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header">
                        <h5 class="mb-0 font-weight-bold mt-1">Boys' Rooms</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered no-wrap" id="boysTable">
                            <thead>
                            <tr>
                                <th>Number</th>
                                <th>Room No.</th>
                                <th>Number of Rooms</th>
                                <th>Fees Per Month</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $query = "SELECT * FROM rooms ORDER BY room_no ASC";
                            $stmt = $mysqli->prepare($query);
                            $stmt->execute();
                            $res = $stmt->get_result();
                            $cnt = 1;
                            while($row = $res->fetch_object()) {
                                if(strtoupper(substr($row->room_no,0,1)) === 'B') {
                                    ?>
                                    <tr>
                                        <td><?php echo $cnt++; ?></td>
                                        <td><?php echo htmlentities($row->room_no); ?></td>
                                        <td><?php echo htmlentities($row->seater); ?></td>
                                        <td>LKR<?php echo htmlentities($row->fees); ?></td>
                                        <td class="actions-cell">
                                            <a href="edit-room.php?id=<?php echo $row->id; ?>" class="btn btn-info btn-action"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="manage-rooms.php?del=<?php echo $row->id; ?>" class="btn btn-danger btn-action" onclick="return confirm('Are you sure you want to delete this record?');"><i class="fas fa-trash-alt"></i> Delete</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            $stmt->close();
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr>

                <!--------------------- GIRLS TABLE ------------------------>
                <div class="card shadow-sm border-0 mt-5">
                    <div class="card-header">
                        <h5 class="mb-0 font-weight-bold mt-1">Girls' Rooms</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered no-wrap" id="girlsTable">
                            <thead>
                            <tr>
                                <th>Number</th>
                                <th>Room No.</th>
                                <th>Number of Rooms</th>
                                <th>Fees Per Month</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $stmt = $mysqli->prepare($query);
                            $stmt->execute();
                            $res = $stmt->get_result();
                            $cnt = 1;
                            while($row = $res->fetch_object()) {
                                if(strtoupper(substr($row->room_no,0,1)) === 'G') {
                                    ?>
                                    <tr>
                                        <td><?php echo $cnt++; ?></td>
                                        <td><?php echo htmlentities($row->room_no); ?></td>
                                        <td><?php echo htmlentities($row->seater); ?></td>
                                        <td>LKR<?php echo htmlentities($row->fees); ?></td>
                                        <td class="actions-cell">
                                            <a href="edit-room.php?id=<?php echo $row->id; ?>" class="btn btn-info btn-action"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="manage-rooms.php?del=<?php echo $row->id; ?>" class="btn btn-danger btn-action" onclick="return confirm('Are you sure you want to delete this record?');"><i class="fas fa-trash-alt"></i> Delete</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            $stmt->close();
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php include '../includes/footer.php' ?>
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

<script>
// Feather icons
feather.replace();

// Live search for both tables
$("#searchAll").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#boysTable tbody tr, #girlsTable tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});
</script>

</body>
</html>
