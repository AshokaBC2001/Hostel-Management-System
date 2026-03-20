<?php
    session_start();
    include('../includes/dbconn.php');
    include('../includes/check-login.php');
    check_login();

    if(isset($_POST['submit'])){
        $seater=$_POST['seater'];
        $fees=$_POST['fees'];
        $id=$_GET['id'];
        $query="UPDATE rooms set seater=?,fees=? where id=?";
        $stmt = $mysqli->prepare($query);
        $rc=$stmt->bind_param('iii',$seater,$fees,$id);
        $stmt->execute();
        echo"<script>alert('Room details has been updated');
        window.location.href='manage-rooms.php';
        </script>";
        }

?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Hostel Management System</title>

    <link href="../dist/css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
    .card {
        border: none;
        border-radius: 1rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .form-control,
    .custom-select {
        border-radius: 0.75rem;
        border: 1px solid #dee2e6;
    }

    .btn {
        border-radius: 0.75rem;
        padding: 0.6rem 1.5rem;
    }

    .card-header {
        border-bottom: none;
        background: #F4F7FC;
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
    }

    .page-title {
        font-weight: 600;
    }
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
                        <h2 class="mb-0 font-weight-bold mt-2">Edit Room Details</h2>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12 col-lg-8">
                        <div class="card shadow-sm border-0">
                            <div class="card-header">
                                <h4 class="mb-0 font-weight-bold mt-2">Room Information</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST">
                                    <?php   
                                    $id=$_GET['id'];
                                    $ret="SELECT * from rooms where id=?";
                                    $stmt= $mysqli->prepare($ret) ;
                                    $stmt->bind_param('i',$id);
                                    $stmt->execute() ;
                                    $res=$stmt->get_result();
                                    while($row=$res->fetch_object()) {
                                        $currentSeater = $row->seater; // Correctly get the current seater value
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="rmno" class="form-label">Room Number</label>
                                            <input type="text" name="rmno" value="<?php echo $row->room_no;?>" id="rmno"
                                                class="form-control" disabled>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="seater" class="form-label">Seater</label>
                                            <select class="form-control custom-select" id="seater" name="seater"
                                                required="required">
                                                <option value="" disabled selected>Select Seater</option>
                                                <?php
                                                    $seatOptions = [2, 4, 6];
                                                    foreach ($seatOptions as $option) {
                                                        $selected = ($currentSeater == $option) ? 'selected' : '';
                                                        echo "<option value='{$option}' {$selected}>{$option} Seater</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="fees" class="form-label">Total Fees</label>
                                            <input type="number" name="fees" id="fees" value="<?php echo $row->fees;?>"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <?php } ?>

                                    <div class="form-actions text-center mt-4">
                                        <button type="submit" name="submit" class="btn btn-success me-2">Update
                                            Room</button>
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                    </div>
                                </form>
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
    <script src="../assets/extra-libs/c3/d3.min.js"></script>
    <script src="../assets/extra-libs/c3/c3.min.js"></script>
    <script src="../assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="../assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="../dist/js/pages/dashboards/dashboard1.min.js"></script>
    <script>
    // Use feather icons
    feather.replace()
    </script>
</body>

</html>