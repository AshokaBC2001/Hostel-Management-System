<?php
include('../includes/dbconn.php');

if (isset($_POST['regno'])) {
    $regno = $_POST['regno'];
    
    $stmt = $mysqli->prepare("SELECT firstName, middleName, lastName, gender, contactNo, email FROM userregistration WHERE regNo=?");
    $stmt->bind_param('s', $regno);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode([]);
    }
    $stmt->close();
}
?>
