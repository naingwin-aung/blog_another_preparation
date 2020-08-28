<?php
session_start();
require_once('config/user_config.php');
$db = new DB();
$db->User_register();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body{
            background-color: whitesmoke;
        }
        .d-flex{
            display: flex;
            flex-wrap: wrap;
            height: 100vh;
            justify-content: center;
            align-content: center;
        }
        .finput {
            width: 100%;
            height: 35px;
            outline: 0;
            border: 1px solid rgb(192, 190, 190);
            padding: 4px;
            border-radius: 3px;
        }
        .login{
            padding: 25px;
            background-color : white;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="container">

                <h3 class="text-center mb-4">User Register</h3>

                <div class="row">
                    <div class="col-md-4 mx-auto login">
                        <p class="text-center">Sign in to the sytem to continue</p>
                        <form action="register.php" method="POST">
                            <div class="form-group">
                                <input type="text" name="name" placeholder="Name" class="finput">
                            </div>

                            <div class="form-group">
                                <input type="email" name="email" placeholder="Email" class="finput">
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" placeholder="Enter password" class="finput">
                            </div>

                            <div class="my-4">
                                <button class="btn btn-primary float-right">Register</button>
                            </div>
                            <a href="login.php">Login</a>
                        </form>
                    </div>
                </div>
        </div>
    </div>
</body>
</html>
