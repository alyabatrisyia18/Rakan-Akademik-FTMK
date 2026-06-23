<?php
include("db_connect.php");

if(isset($_POST['btnReset']))
{
    $userId = $_POST['txtUserId'];
    $newPassword = $_POST['txtPassword'];
    $confirmPassword = $_POST['txtConfirmPassword'];

    if($newPassword != $confirmPassword)
    {
        echo "
        <script>
        alert('Password does not match');
        </script>
        ";
    }
    else
    {
        $sql = "SELECT * FROM user WHERE userId='$userId'";
        $result = mysqli_query($conn,$sql);

        if(mysqli_num_rows($result) > 0)
        {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $update = "UPDATE user
                       SET password='$hashedPassword'
                       WHERE userId='$userId'";

            mysqli_query($conn,$update);

            echo "
            <script>
            alert('Password Successfully Reset');
            window.location.href='login.php';
            </script>
            ";
        }
        else
        {
            echo "
            <script>
            alert('User ID Not Found');
            </script>
            ";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Forgot Password</title>

<style>

body{
    font-family:Segoe UI;
    background:#f5f7fa;
}

.container{
    width:400px;
    background:white;
    padding:30px;
    margin:80px auto;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

h2{
    text-align:center;
    margin-bottom:25px;
}

.inputBox{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:5px;
}

.resetBtn{
    width:100%;
    padding:12px;
    border:none;
    background:#6CB6E9;
    color:white;
    cursor:pointer;
    border-radius:5px;
}

.resetBtn:hover{
    background:#54A8E2;
}

.backBtn{
    display:block;
    text-align:center;
    margin-top:15px;
    text-decoration:none;
}

</style>

</head>

<body>

<div class="container">

    <h2>Reset Password</h2>

    <form method="POST">

        <input
        type="text"
        name="txtUserId"
        class="inputBox"
        placeholder="Enter Student ID"
        required>

        <input
        type="password"
        name="txtPassword"
        class="inputBox"
        placeholder="New Password"
        required>

        <input
        type="password"
        name="txtConfirmPassword"
        class="inputBox"
        placeholder="Confirm Password"
        required>

        <input
        type="submit"
        name="btnReset"
        value="Reset Password"
        class="resetBtn">

    </form>

    <a href="login.php" class="backBtn">
        Back To Login
    </a>

</div>

</body>
</html>