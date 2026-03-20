<?php
session_start();
include('../includes/dbconn.php');
include('../includes/check-login.php');
check_login();


// COUNT: Students Who Booked Hostel

$bookedStudents = 0;
$queryBookedStudents = "SELECT COUNT(*) AS total FROM registration 
                        WHERE roomno IS NOT NULL AND roomno != ''";
$resBooked = $mysqli->query($queryBookedStudents);
if ($resBooked) {
    $rowBooked = $resBooked->fetch_assoc();
    $bookedStudents = $rowBooked['total'];
}


// ROOM AVAILABILITY PANEL DATA

$rooms = $mysqli->query("SELECT room_no, seater FROM rooms ORDER BY room_no ASC");

// Fetch bookings grouped by roomno
$bookings = [];
$getBookings = $mysqli->query("SELECT roomno, COUNT(*) AS booked FROM registration GROUP BY roomno");
while ($b = $getBookings->fetch_assoc()) {
    $bookings[$b['roomno']] = $b['booked'];
}

// Separate girls and boys rooms
$girlsRooms = [];
$boysRooms = [];
while ($room = $rooms->fetch_assoc()) {
    if (strtoupper(substr($room['room_no'], 0, 1)) === 'G') {
        $girlsRooms[] = $room;
    } elseif (strtoupper(substr($room['room_no'], 0, 1)) === 'B') {
        $boysRooms[] = $room;
    }
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
<link href="../assets/extra-libs/c3/c3.min.css" rel="stylesheet">
<link href="../dist/css/style.min.css" rel="stylesheet">

<style>
/* ADMIN DASHBOARD CSS) */
.card { border: none; border-radius: 1rem; transition: 0.2s; }
.card:hover { transform: translateY(-3px); box-shadow: 0 6px 16px rgba(0,0,0,0.1); }
.icon-box { display: flex; justify-content: center; align-items: center; height: 50px; width: 50px; border-radius: 50%; background: #eef2f7; }
.card-header { border-bottom: none; background: #F4F7FC; }
table thead { background-color: #e7ebf4; }
.badge { font-size: 0.85rem; }


/* ROOM AVAILABILITY PANEL CSS (UNCHANGED) */

.room-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    grid-gap: 20px;
    padding: 20px 10px 20px 10px;
}

.room-card {
    background: #f4f7fc;
    border-radius: 1rem;
    padding: 10px;
    border: 1px solid #f4f7fc;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    transition: 0.3s ease;
}

.room-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 18px rgba(0,0,0,0.1);
}

.room-title {
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 10px;
    text-align: center;
    color: #002651;
}

.bed-container { display: grid; gap: 8px; }

.bed-box {
    height: 35px;
    border-radius: 8px;
    border: 1.5px solid #cbd5e0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f4f7fc;
    color: #2d3748;
    font-weight: 600;
    font-size: 11px;
    transition: 0.25s;
}

.bed-booked {
    background: #aab9d6;
    color: white;
    border-color: #aab9d6;
}

.room-full {
    border-color: #7f8ebf !important;
    box-shadow: 0 5px 12px rgba(0,0,0,0.1);
}

.section-subtitle {
    font-size: 16px;
    font-weight: 600;
    margin-top: 15px;
    margin-bottom: 10px;
    color: #002651;
}

#roomSearch { width: 625px; }

.filter-box {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #f4f7fc;
    border: 1px solid #e0e0e0;
    border-radius: 0.75rem;
    padding: 5px 12px;
    cursor: pointer;
    font-size: 14px;
    color: #002651;
}

.filter-checkbox {
    width: 18px;
    height: 18px;
    accent-color: #aab9d6;
}
</style>

</head>

<body>

<div class="preloader">
    <div class="lds-ripple"><div class="lds-pos"></div><div class="lds-pos"></div></div>
</div>

<div id="main-wrapper" data-theme="light" data-layout="vertical" 
     data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed" 
     data-boxed-layout="full">

    <header class="topbar" data-navbarbg="skin6">
        <?php include 'includes/navigation.php' ?>
    </header>

    <aside class="left-sidebar" data-sidebarbg="skin6">
        <div class="scroll-sidebar">
            <?php include 'includes/sidebar.php' ?>
        </div>
    </aside>

    <div class="page-wrapper">

        <!-- Breadcrumb -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 align-self-center">
                    <?php include 'includes/greetings-a.php' ?>
                </div>
            </div>
        </div>

        <div class="container-fluid">

            <!-- === Dashboard Cards Row === -->
            <div class="row">

                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="mb-0 text-primary"><?php include 'counters/student-count.php' ?></h3>
                                <p class="text-muted mb-0">Total Users</p>
                            </div>
                            <div class="icon-box"><i data-feather="user-plus" class="text-primary"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="mb-0 text-success"><?php include 'counters/room-count.php' ?></h3>
                                <p class="text-muted mb-0">Total Rooms</p>
                            </div>
                            <div class="icon-box"><i data-feather="grid" class="text-success"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="mb-0 text-info"><?php include 'counters/booked-count.php' ?></h3>
                                <p class="text-muted mb-0">Booked Rooms</p>
                            </div>
                            <div class="icon-box"><i data-feather="bookmark" class="text-info"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="mb-0 text-warning"><?php echo $bookedStudents; ?></h3>
                                <p class="text-muted mb-0">All Residents</p>
                            </div>
                            <div class="icon-box"><i data-feather="users" class="text-warning"></i></div>
                        </div>
                    </div>
                </div>

            </div>

            
            <!-- ROOM AVAILABILITY PANEL-->
            
            <div class="card shadow-sm border-0 p-3 mb-4" style="background: #f4f7fc; border-radius: 1rem;">
                <h4 class="mb-3 font-weight-bold">Room Availability</h4>
                <br>

                <!-- Search + Filters -->
                <div class="d-flex align-items-center mb-3 flex-wrap" style="gap: 10px;">
                    <input type="text" class="form-control search-box" id="roomSearch" placeholder="Search Rooms...">

                    <div class="filter-box">
                        <input type="checkbox" id="filterFull" class="filter-checkbox">
                        <label for="filterFull">Fully Booked</label>
                    </div>

                    <div class="filter-box">
                        <input type="checkbox" id="filterAvailable" class="filter-checkbox">
                        <label for="filterAvailable">Available</label>
                    </div>
                </div>

                <!-- Girls Rooms -->
                <div class="section-subtitle">Girls Rooms</div>
                <div class="room-grid" id="girlsRoomsContainer">
                <?php foreach ($girlsRooms as $room):
                    $room_no = $room['room_no'];
                    $total_beds = $room['seater'];
                    $booked = isset($bookings[$room_no]) ? $bookings[$room_no] : 0;
                    $isFull = ($booked >= $total_beds);
                ?>
                    <div class="room-card <?php echo $isFull ? 'room-full' : ''; ?>" data-room="<?php echo $room_no; ?>">
                        <div class="room-title"><?php echo $room_no; ?></div>
                        <div class="bed-container" style="grid-template-columns: repeat(<?php echo $total_beds; ?>, 1fr);">
                        <?php for ($i = 1; $i <= $total_beds; $i++):
                            $class = ($i <= $booked) ? "bed-box bed-booked" : "bed-box";
                            $label = ($i <= $booked) ? "Booked" : "Free";
                        ?>
                            <div class="<?php echo $class; ?>"><span><?php echo $label; ?></span></div>
                        <?php endfor; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>

                <hr>

                <!-- Boys Rooms -->
                <div class="section-subtitle">Boys Rooms</div>
                <div class="room-grid" id="boysRoomsContainer">
                <?php foreach ($boysRooms as $room):
                    $room_no = $room['room_no'];
                    $total_beds = $room['seater'];
                    $booked = isset($bookings[$room_no]) ? $bookings[$room_no] : 0;
                    $isFull = ($booked >= $total_beds);
                ?>
                    <div class="room-card <?php echo $isFull ? 'room-full' : ''; ?>" data-room="<?php echo $room_no; ?>">
                        <div class="room-title"><?php echo $room_no; ?></div>
                        <div class="bed-container" style="grid-template-columns: repeat(<?php echo $total_beds; ?>, 1fr);">
                        <?php for ($i = 1; $i <= $total_beds; $i++):
                            $class = ($i <= $booked) ? "bed-box bed-booked" : "bed-box";
                            $label = ($i <= $booked) ? "Booked" : "Free";
                        ?>
                            <div class="<?php echo $class; ?>"><span><?php echo $label; ?></span></div>
                        <?php endfor; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
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
feather.replace();

// Room Search + Filters
const roomSearch = document.getElementById('roomSearch');
const filterFull = document.getElementById('filterFull');
const filterAvailable = document.getElementById('filterAvailable');

function filterRooms() {
    let filterText = roomSearch.value.toUpperCase();
    let girls = document.querySelectorAll('#girlsRoomsContainer .room-card');
    let boys = document.querySelectorAll('#boysRoomsContainer .room-card');

    function checkRoom(room) {
        let roomNo = room.getAttribute('data-room').toUpperCase();
        let isFull = room.classList.contains('room-full');

        let matchesSearch = roomNo.indexOf(filterText) > -1;

        let matchesFilter = true;
        if (filterFull.checked && !isFull) matchesFilter = false;
        if (filterAvailable.checked && isFull) matchesFilter = false;

        room.style.display = (matchesSearch && matchesFilter) ? '' : 'none';
    }

    girls.forEach(checkRoom);
    boys.forEach(checkRoom);
}

roomSearch.addEventListener('keyup', filterRooms);
filterFull.addEventListener('change', filterRooms);
filterAvailable.addEventListener('change', filterRooms);
</script>

</body>
</html>
