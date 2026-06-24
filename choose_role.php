<?php
session_start();

if(!isset($_SESSION['matric']))
{
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html>
<head>

<title>Choose Role</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Segoe UI,sans-serif;
}

body{
    background:rgba(0,0,0,0.4);
}

.overlay{
    position:fixed;
    width:100%;
    height:100%;

    display:flex;
    justify-content:center;
    align-items:center;

    background:rgba(0,0,0,0.35);
}

.modalBox{
    width:550px;
    background:white;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 5px 20px rgba(0,0,0,0.25);
}

.modalHeader{
    padding:25px;
    background:#f8f8f8;
    font-size:24px;
    font-weight:bold;
}

.modalBody{
    padding:35px;
}

.roleButton{
    width:100%;
    height:80px;

    border:1px solid #dcdcdc;
    border-radius:10px;

    text-decoration:none;
    color:black;

    display:flex;
    align-items:center;

    padding-left:25px;

    font-size:26px;

    margin-bottom:20px;

    transition:0.3s;
}

.roleButton:hover{
    background:#f3f9ff;
    border-color:#6CB6E9;
}

.roleButton i{
    margin-right:20px;
}

.closeBtn{
    position:absolute;
    top:30px;
    right:40px;

    font-size:32px;
    color:black;
    text-decoration:none;
}

</style>

</head>

<body>

<div class="overlay">

    <a href="login.php" class="closeBtn">
        <i class="fa-solid fa-xmark"></i>
    </a>

    <div class="modalBox">

        <div class="modalHeader">
            Choose Your Role
        </div>

        <div class="modalBody">

            <a href="dashboard.php" class="roleButton">
                <i class="fa-regular fa-user"></i>
                As Student
            </a>

            <?php
            if($role == "Tutor")
            {
            ?>
                <a href="rakan_dashboard.php" class="roleButton">
                    <i class="fa-regular fa-user"></i>
                    As Rakan Akademik
                </a>
            <?php
            }
            ?>

        </div>

    </div>

</div>

</body>
</html>