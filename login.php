<?php
include 'koneksi.php';
session_start();

if (isset($_POST['masuk'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Protect against SQL Injection
    $username = mysqli_real_escape_string($dbconnect, $username);
    $password = mysqli_real_escape_string($dbconnect, $password);

    $query = mysqli_query($dbconnect, "SELECT * FROM user WHERE username='$username' and password='$password'");

    // Mendapatkan hasil dari data
    $data = mysqli_fetch_assoc($query);

    // Mendapatkan nilai jumlah data
    $check = mysqli_num_rows($query);

    if ($check == 0) {
        $_SESSION['error'] = 'Username & password salah';
    } else {
        $_SESSION['username'] = $data['username'];
        header('Location: index.php');
        exit(); // Always call exit after header redirect
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style>
        body {
            background-image: url('images/bg.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1);
            width: 200px;
            height: 300px;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
<br><br><br><br>    
<div class="container-fluid" id="wrapper">
    <div class="card">
        <div class="panel panel-secondary center">
            <div class="panel-heading">ABSENSI JANIMANI </div>
            <div class="panel-body">
                <form method="post" class="form-signin">
                    <!-- Alert -->
                    <?php if (isset($_SESSION['error']) && $_SESSION['error'] != '') { ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $_SESSION['error'] ?>
                        </div>
                    <?php }
                    $_SESSION['error'] = '';
                    ?>
                    <label class="form-label">Username </label>
                    <label class="sr-only">Username</label><br>            
                    <input type="text" class="form-control" name="username" placeholder="Username"><br>
                    <label class="form-label">Password </label>
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password"><br>
                    <input type="submit" name="masuk" value="Sign in" class="btn btn-sm btn-secondary btn-block"/>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
