<?php
session_start();
include('includes/dbconn.php');

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    
    $stmt = $mysqli->prepare("SELECT email, password, id FROM userregistration WHERE email=? AND password=?");
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    $stmt->bind_result($db_email, $db_password, $id);
    $rs = $stmt->fetch();
    $stmt->close();
    
    if($rs) {
        $_SESSION['id'] = $id;
        $_SESSION['login'] = $email;
        $ip = $_SERVER['REMOTE_ADDR'];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.geoplugin.net/php.gp?ip='.$ip);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $addrDetailsArr = unserialize(curl_exec($ch));
        curl_close($ch);
        
        $city = isset($addrDetailsArr['geoplugin_city']) ? $addrDetailsArr['geoplugin_city'] : 'Unknown';
        $country = isset($addrDetailsArr['geoplugin_countryName']) ? $addrDetailsArr['geoplugin_countryName'] : 'Unknown';

        $log = "INSERT INTO userLog (userId, userEmail, userIp, city, country) VALUES (?, ?, ?, ?, ?)";
        $stmt_log = $mysqli->prepare($log);
        $stmt_log->bind_param('issss', $id, $email, $ip, $city, $country);
        $stmt_log->execute();
        $stmt_log->close();

        header("Location: student/dashboard.php");
        exit();
    } else {
        echo "<script>alert('Sorry, Invalid Username/Email or Password!');</script>";
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
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

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
        background-color: #E6ECF5;
        overflow-x: hidden; /* Prevent horizontal scroll */
    }

    .login-wrapper, .register-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        height: 100%;
        padding: 2rem;
        box-sizing: border-box;
    }

    /* Login Card */
    .login-card {
        background-color: var(--card-bg);
        border-radius: 1.5rem;
        box-shadow: 0 1rem 3rem rgba(0,0,0,0.05);
        padding: 2.5rem 2rem;
        width: 100%;
        max-width: 500px;  /* Responsive width */
        text-align: center;
        animation: fadeIn 0.8s ease-out;
    }

    /* Register Card */
    .register-card {
        background-color: var(--card-bg);
        border-radius: 1.5rem;
        box-shadow: 0 1rem 3rem rgba(0,0,0,0.05);
        padding: 2.5rem 2rem;
        width: 100%;
        max-width: 850px; /* Responsive width */
        text-align: center;
        animation: fadeIn 0.8s ease-out;
    }

    .login-card h2,
    .register-card h2 {
        font-weight: 600;
        color: var(--font-color);
        margin-bottom: 1.5rem;
        font-size: 1.75rem;
    }

    .form-group {
        text-align: left;
        margin-bottom: 1.2rem;
    }

    .form-group label {
        display: block;
        font-size: 0.9rem;
        font-weight: 500;
        color: #002651;
        margin-bottom: 0.5rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        border-radius: 0.5rem;
        border: 1px solid var(--border-color);
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 38, 81, 0.1);
    }

    .btn-login, .btn-register {
        width: 100%;
        padding: 1rem;
        border: none;
        border-radius: 0.5rem;
        font-size: 1rem;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(45deg, var(--primary-color), var(--primary-hover));
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-login:hover, .btn-register:hover {
        box-shadow: 0 6px 20px rgba(0, 38, 81, 0.3);
    }

    .link-container {
        margin-top: 1.2rem;
        font-size: 0.9rem;
    }

    .link-container a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
    }

    .link-container a:hover {
        color: var(--primary-hover);
        text-decoration: underline;
    }
    @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
    }

</style>
</head>

<body>
    <div class="login-wrapper">
        <div class="login-card">
            <img src="assets/images/big/user-icn.png" alt="Hostel Logo" class="logo">
            <h2>Student Login</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email"
                        required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password"
                        placeholder="Enter your password" required>
                </div>
                <button type="submit" name="login" class="btn-login">LOGIN</button>
            </form>
            <div class="link-container">
                <a href="admin/rwln.php">Register</a>
            </div>
            <div class="link-container">
                <a href="admin/index.php">Go to Admin Panel</a>
            </div>
        </div>
    </div>
</body>

</html>