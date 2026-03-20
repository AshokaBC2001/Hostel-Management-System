<?php
    include '../includes/dbconn.php';

    // Count UNIQUE room numbers that are booked
    $sql = "SELECT DISTINCT roomno FROM registration 
            WHERE roomno IS NOT NULL AND roomno != ''";

    $query = $mysqli->query($sql);
    echo $query->num_rows;
?>
