<?php
session_start();
include('../includes/dbconn.php');
include('../includes/check-login.php');
check_login();

if (isset($_POST['submit'])) {
    $roomno      = $_POST['room'];
    $seater      = $_POST['seater'];
    $feespm      = $_POST['fpm'];
    $stayfrom    = $_POST['stayf'];
    $duration    = $_POST['duration'];
    $regno       = $_POST['regno'];
    $fname       = $_POST['fname'];
    $mname       = $_POST['mname'];
    $lname       = $_POST['lname'];
    $gender      = $_POST['gender'];
    $contactno   = $_POST['contact'];
    $emailid     = $_POST['email'];
    $gurname     = $_POST['gname'];
    $gurrelation = $_POST['grelation'];
    $gurcntno    = $_POST['gcontact'];
    $caddress    = $_POST['address'];
    $ccity       = $_POST['city'];

    $query = "INSERT into registration(roomno,seater,feespm,stayfrom,duration,regno,firstName,middleName,lastName,gender,contactno,emailid,guardianName,guardianRelation,guardianContactno,corresAddress,corresCIty) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('siisisssssisssiss',$roomno, $seater, $feespm, $stayfrom, $duration,$regno, $fname, $mname, $lname, $gender,$contactno, $emailid, $gurname, $gurrelation,$gurcntno, $caddress, $ccity);
    $stmt->execute();
    echo "<script>alert('Success: Booked!');</script>";
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Hostel Management System</title>
<link href="../dist/css/style.min.css" rel="stylesheet">
<style>
.card {border:none; border-radius:1rem; transition:transform 0.2s ease, box-shadow 0.2s ease; box-shadow:0 4px 8px rgba(0,0,0,0.05);}
.card:hover {transform:translateY(-3px); box-shadow:0 6px 16px rgba(0,0,0,0.1);}
.form-control, .custom-select {border-radius:0.75rem; border:1px solid #dee2e6;}
.btn {border-radius:0.75rem; padding:0.6rem 1.5rem;}
.card-header {border-bottom:none; background:#F4F7FC; border-top-left-radius:1rem; border-top-right-radius:1rem;}
.page-title {font-weight:600;}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function getSeater(val) {
    $.ajax({
        type: "POST",
        url: "get-seater.php",
        data: 'roomid=' + val,
        success: function(data) { $('#seater').val(data); }
    });
    $.ajax({
        type: "POST",
        url: "get-seater.php",
        data: 'rid=' + val,
        success: function(data) { $('#fpm').val(data); calculateTotalAmount(); }
    });
}

function calculateTotalAmount() {
    var fees = parseFloat($('#fpm').val());
    var duration = parseInt($('#duration').val());
    if (!isNaN(fees) && !isNaN(duration)) { $('#ta').val(fees * duration); }
    else { $('#ta').val(''); }
}

$(document).ready(function() {

    $('#duration, #fpm').on('change keyup', function() { calculateTotalAmount(); });

    $('#regno').on('keyup change', function() {
        var regno = $(this).val();
        if(regno.length > 0){
            $.ajax({
                type: "POST",
                url: "get-student-info.php",
                data: {regno: regno},
                dataType: "json",
                success: function(data) {

                    if(data && Object.keys(data).length > 0){

                        $('#fname').val(data.firstName);
                        $('#mname').val(data.middleName);
                        $('#lname').val(data.lastName);
                        $('#contact').val(data.contactNo);
                        $('#email').val(data.email);

                        // ⭐ FIXED GENDER AUTO-FILL ⭐
                        let g = (data.gender || "").toString().trim().toLowerCase();
                        if(g === "male" || g === "m") {
                            $('select[name="gender"]').val("male");
                        } 
                        else if(g === "female" || g === "f") {
                            $('select[name="gender"]').val("female");
                        } 
                        else {
                            $('select[name="gender"]').val("");
                        }

                    } else {
                        $('#fname,#mname,#lname,#contact,#email').val('');
                        $('select[name="gender"]').val('');
                    }
                }
            });
        } else {
            $('#fname,#mname,#lname,#contact,#email').val('');
            $('select[name="gender"]').val('');
        }
    });
});
</script>

</head>
<link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
<body>
<div class="preloader">
    <div class="lds-ripple"><div class="lds-pos"></div><div class="lds-pos"></div></div>
</div>

<div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
<header class="topbar" data-navbarbg="skin6"><?php include 'includes/navigation.php' ?></header>
<aside class="left-sidebar" data-sidebarbg="skin6"><div class="scroll-sidebar" data-sidebarbg="skin6"><?php include 'includes/sidebar.php' ?></div></aside>

<div class="page-wrapper">
<div class="page-breadcrumb"><div class="row"><div class="col-12 align-self-center"><h2 class="mb-0 font-weight-bold mt-2">Book Hostel</h2></div></div></div>

<div class="container-fluid">
<form method="POST">

<!-- Room Details Card -->
<div class="card shadow-sm border-0 mb-4">
<div class="card-header"><h4 class="mb-0 font-weight-bold mt-2">Room Details</h4></div>
<div class="card-body">
<div class="row">

<div class="col-md-6 col-lg-4 mb-4">
<label for="room" class="form-label">Room Number</label>
<select class="form-control custom-select" name="room" id="room" onChange="getSeater(this.value);" required>
<option selected>Select...</option>
<?php
$query = "SELECT * FROM rooms";
$stmt2 = $mysqli->prepare($query);
$stmt2->execute();
$res = $stmt2->get_result();
while ($row = $res->fetch_object()) { ?>
<option value="<?php echo $row->room_no; ?>"> <?php echo $row->room_no; ?> </option>
<?php } ?>
</select>
</div>

<div class="col-md-6 col-lg-4 mb-4">
<label for="stayf" class="form-label">Start Date</label>
<input type="date" name="stayf" id="stayf" class="form-control" required>
</div>

<div class="col-md-6 col-lg-4 mb-4">
<label for="seater" class="form-label">Number of Beds</label>
<select class="form-control custom-select" id="seater" name="seater" required>
<option value="">Choose...</option>
<option value="2">Two Beds</option>
<option value="4">Four Beds</option>
<option value="6">Six Beds</option>
</select>
</div>

<div class="col-md-6 col-lg-4 mb-4">
<label for="duration" class="form-label">Total Duration</label>
<select class="form-control custom-select" id="duration" name="duration">
<option selected>Choose...</option>
<option value="1">One Month</option>
<option value="2">Two Month</option>
<option value="3">Three Month</option>
</select>
</div>

<div class="col-md-6 col-lg-4 mb-4">
<label for="fpm" class="form-label">Total Fees Per Month</label>
<input type="text" name="fpm" id="fpm" placeholder="Your total fees" class="form-control">
</div>

<div class="col-md-6 col-lg-4 mb-4">
<label for="ta" class="form-label">Total Amount</label>
<input type="text" name="ta" id="ta" placeholder="Total Amount here.." class="form-control" readonly>
</div>

</div>
</div>
</div>

<!-- Student Personal Info Card -->
<div class="card shadow-sm border-0 mb-4">
<div class="card-header"><h4 class="mb-0 font-weight-bold mt-2">Student's Personal Information</h4></div>
<div class="card-body">
<div class="row">

<div class="col-md-6 col-lg-4 mb-4"><label for="regno" class="form-label">Registration Number</label><input type="text" name="regno" id="regno" placeholder="Enter registration number" class="form-control" required></div>

<div class="col-md-6 col-lg-4 mb-4"><label for="fname" class="form-label">First Name</label><input type="text" name="fname" id="fname" placeholder="Enter first name" class="form-control" required></div>

<div class="col-md-6 col-lg-4 mb-4"><label for="mname" class="form-label">Middle Name</label><input type="text" name="mname" id="mname" placeholder="Enter middle name" class="form-control"></div>

<div class="col-md-6 col-lg-4 mb-4"><label for="lname" class="form-label">Last Name</label><input type="text" name="lname" id="lname" placeholder="Enter last name" class="form-control"></div>

<div class="col-md-6 col-lg-4 mb-4"><label for="email" class="form-label">Email</label><input type="email" name="email" id="email" placeholder="Enter email address" class="form-control" required></div>

<div class="col-md-6 col-lg-4 mb-4">
<label for="gender" class="form-label">Gender</label>
<select name="gender" class="form-control" required>
<option value="">Select Gender</option>
<option value="male">Male</option>
<option value="female">Female</option>
</select>
</div>

<div class="col-md-6 col-lg-4 mb-4"><label for="contact" class="form-label">Contact Number</label><input type="number" name="contact" id="contact" placeholder="Enter contact number" class="form-control" required></div>

</div>
</div>
</div>

<!-- Guardian Details Card -->
<div class="card shadow-sm border-0 mb-4">
<div class="card-header"><h4 class="mb-0 font-weight-bold mt-2">Guardian Details</h4></div>
<div class="card-body">
<div class="row">

<div class="col-md-6 col-lg-4 mb-4"><label for="gname" class="form-label">Guardian Name</label><input type="text" name="gname" id="gname" placeholder="Enter Guardian Name" class="form-control" required></div>

<div class="col-md-6 col-lg-4 mb-4"><label for="grelation" class="form-label">Guardian Relation</label><input type="text" name="grelation" id="grelation" placeholder="Enter Relation" class="form-control" required></div>

<div class="col-md-6 col-lg-4 mb-4"><label for="gcontact" class="form-label">Guardian Contact</label><input type="text" name="gcontact" id="gcontact" placeholder="Enter Guardian Contact" class="form-control" required></div>

</div>
</div>
</div>

<!-- Current Address -->
<div class="card shadow-sm border-0 mb-4">
<div class="card-header"><h4 class="mb-0 font-weight-bold mt-2">Current Living Address</h4></div>
<div class="card-body">
<div class="row">

<div class="col-md-6 col-lg-4 mb-4"><label for="address" class="form-label">Address</label><textarea name="address" id="address" class="form-control" placeholder="Enter Address" rows="3" required></textarea></div>

<div class="col-md-6 col-lg-4 mb-4"><label for="city" class="form-label">City</label><input type="text" name="city" id="city" placeholder="Enter City" class="form-control" required></div>

</div>
</div>
</div>

<div class="form-actions text-center mt-4">
<button type="submit" name="submit" class="btn btn-success me-2">Submit</button>
<button type="reset" class="btn btn-danger">Reset</button>
</div>

</form>
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

</body>
</html>
