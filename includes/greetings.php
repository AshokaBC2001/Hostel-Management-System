<?php 
    // Set timezone (optional, can keep for consistency)
    date_default_timezone_set('Asia/Colombo');

    $welcome_string = "Welcome";

    $aid = $_SESSION['id'];
    $ret = "SELECT * FROM userregistration WHERE id=?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('i', $aid);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_object()) {
        echo "<h2 class='mb-0 font-weight-bold mt-2'>$welcome_string $row->firstName!</h2>";
    }
?>