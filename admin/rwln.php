<?php
include('../includes/dbconn.php'); // keep only DB connection

if (isset($_POST['submit'])) {
    $regno     = $_POST['regno'];
    $fname     = $_POST['fname'];
    $mname     = $_POST['mname'];
    $lname     = $_POST['lname'];
    $gender    = $_POST['gender'];
    $contactno = $_POST['contact'];
    $emailid   = $_POST['email'];
    $password  = md5($_POST['password']); // keep md5 for existing system

    // Check if student already exists
    $stmt_check = $mysqli->prepare("SELECT COUNT(*) FROM userRegistration WHERE regNo = ? OR email = ?");
    $stmt_check->bind_param('ss', $regno, $emailid);
    $stmt_check->execute();
    $stmt_check->bind_result($count);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($count > 0) {
        echo "<script>alert('Student with this Registration Number or Email already exists!');</script>";
    } else {
        $query = "INSERT into userRegistration(regNo,firstName,middleName,lastName,gender,contactNo,email,password) values(?,?,?,?,?,?,?,?)";
        $stmt  = $mysqli->prepare($query);
        $stmt->bind_param('sssssiss', $regno, $fname, $mname, $lname, $gender, $contactno, $emailid, $password);
        if ($stmt->execute()) {
            echo "<script>alert('Student Registered Successfully!');</script>";
        } else {
            echo "<script>alert('Error: Could not register.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Registration</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
:root {
    --primary-color: #0056b3;
    --primary-hover: #0056b3;
    --card-bg: #F4F7FC;
    --font-color: #002651;
    --border-color: #e7ebf4;
    --shadow-light: rgba(0, 0, 0, 0.05);
}

body, html {
    height: 100%;
    margin: 0;
    font-family: 'Calibri';
    background: linear-gradient(135deg, #E6ECF5, #E6ECF5);
}

.register-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    padding: 0 1rem;
}

.register-card {
    background-color: var(--card-bg);
    border-radius: 1.5rem;
    box-shadow: 0 1rem 3rem var(--shadow-light);
    padding: 1.2rem 1.5rem;
    width: 100%;
    max-width: 550px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    animation: fadeIn 0.8s ease-out;
}

.register-card h3 {
    font-weight: 700;
    color: var(--font-color);
    margin-bottom: 1rem;
    text-align: center;
}

.register-card form {
    margin: 0;
}

.form-label {
    font-size: 0.85rem;
    font-weight: 500;
    color: #002651;
    margin-bottom: 0.25rem;
}

.form-control {
    border-radius: 0.5rem;
    border: 1px solid var(--border-color);
    padding: 0.5rem;
    margin-bottom: 0.5rem;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.1);
}

.btn-success, .btn-danger {
    width: 130px;
    padding: 0.5rem 0;
    border-radius: 0.6rem;
    font-weight: 600;
    align-self: center;
    margin-top: 0.5rem;
}

.btn-success {
    border: none;
    color: #F4F7FC;
    background: linear-gradient(45deg, #0056b3, #0056b3);
    box-shadow: 0 4px 10px rgba(255, 255, 255, 1);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.btn-success:hover {
    box-shadow: 0 6px 15px rgba(255, 255, 255, 0.3);
}

.link-container a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s ease;
    font-size: 0.9rem;
}

.link-container a:hover {
    color: var(--primary-hover);
    text-decoration: underline;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

<script>
function valid() {
    if (document.registration.password.value !== document.registration.cpassword.value) {
        alert("Password and Confirm Password do not match");
        document.registration.cpassword.focus();
        return false;
    }
    return true;
}
</script>
</head>
<body>
<div class="register-wrapper">
    <div class="register-card">
        <h3>Student Registration</h3>
        <hr>
        <form method="POST" name="registration" onsubmit="return valid();">
            <div class="row g-2">
                <div class="col-md-6">
                    <label class="form-label">Registration Number</label>
                    <input type="text" name="regno" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">First Name</label>
                    <input type="text" name="fname" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Middle Name</label>
                    <input type="text" name="mname" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="lname" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-control" required>
                        <option value="">Choose...</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Contact Number</label>
                    <input type="number" name="contact" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email ID</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="cpassword" class="form-control" required>
                </div>
            </div>
            <div class="text-center mt-3">
                <button type="submit" name="submit" class="btn btn-success me-2">Register</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
            <div class="text-center link-container mt-2">
                <a href="../index.php">Back to Student Login</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
