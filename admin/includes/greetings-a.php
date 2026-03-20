<?php 
    // Optional: Set timezone
    date_default_timezone_set('Asia/Colombo');

    $welcome_string = "Welcome";

    // Get admin details
    $aid = $_SESSION['id']; // assuming admin ID is stored in session
    $ret = "SELECT * FROM admin WHERE id=?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('i', $aid);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_object()) {
        echo "<h2 class='mb-0 font-weight-bold mt-2'>$welcome_string $row->username!</h2>";
    }
?>
