<?php

include("db_connect.php");

if(isset($_POST["btnReset"]))
{
    $userId = $_POST["txtUserId"];
    $email = $_POST["txtEmail"];
    $password = $_POST["txtPassword"];
    $confirmPassword = $_POST["txtConfirmPassword"];

    if($password != $confirmPassword)
    {
        echo "
        <script>
        alert('Password does not match!');
        </script>
        ";
    }
    else
    {
        $checkUser = mysqli_query(
            $conn,
            "SELECT * FROM user
             WHERE userId='$userId'
             AND email='$email'"
        );

        if(mysqli_num_rows($checkUser) > 0)
        {
            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            mysqli_query(
                $conn,
                "UPDATE user
                 SET password='$hashedPassword'
                 WHERE userId='$userId'"
            );

            echo "
            <script>
            alert('Password Successfully Reset');
            window.location='login.php';
            </script>
            ";
        }
        else
        {
            echo "
            <script>
            alert('Invalid User ID or Email');
            </script>
            ";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>

<meta charset='UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>

<title>Forgot Password</title>

<style>

body{
    font-family:Segoe UI,sans-serif;
    background:#EEF3FA;
}

.resetBox{
    width:420px;
    background:white;
    padding:30px;
    margin:80px auto;
    border-radius:8px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

h2{
    text-align:center;
    margin-bottom:20px;
}

.textBox{
    width:100%;
    padding:10px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:4px;
}

.resetButton{
    width:100%;
    padding:12px;
    border:none;
    background:#2748A5;
    color:white;
    cursor:pointer;
}

.resetButton:hover{
    background:#1d3987;
}

.backLogin{
    text-align:center;
    margin-top:15px;
}

.backLogin a{
    text-decoration:none;
    color:#2748A5;
}

</style>

</head>

<body>

<div class="resetBox">

    <h2>Reset Password</h2>

    <form method="POST">

        <input
            type="text"
            name="txtUserId"
            class="textBox"
            placeholder="User ID"
            required>

        <input
            type="email"
            name="txtEmail"
            class="textBox"
            placeholder="Registered Email"
            required>

        <input
            type="password"
            name="txtPassword"
            class="textBox"
            placeholder="New Password"
            required>

        <input
            type="password"
            name="txtConfirmPassword"
            class="textBox"
            placeholder="Confirm Password"
            required>

        <input
            type="submit"
            name="btnReset"
            value="Reset Password"
            class="resetButton">

    </form>

    <div class="backLogin">

        <a href="login.php">
            Back To Login
        </a>

    </div>

</div>

</body>
</html>