<?php
session_start();

if(!isset($_SESSION['matric']))
{
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Choose Dashboard</title>

    <style>

body{
    margin:0;
    font-family:Segoe UI;
    background-image: url('images/edubackground.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
}

.container{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.box{
    background: rgba(255,255,255,0.85);
    padding:40px;
    border-radius:15px;
    width:420px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
    backdrop-filter: blur(5px);
}

h1{
    color:#1f3c88;
    margin-bottom:10px;
    font-size:28px;
}

h3{
    color:#1f3c88;
    margin-bottom:20px;
}

.welcome-text{
    color:#555;
    margin-bottom:25px;
}

.btn{
    display:block;
    width:100%;
    padding:14px;
    margin-bottom:12px;
    text-decoration:none;
    background:#3fa9f5;
    color:white;
    border-radius:8px;
    font-size:16px;
    font-weight:bold;
    transition:0.3s;
}

.btn:hover{
    background:#1b8ce3;
    transform: translateY(-2px);
}

    </style>
</head>

<body>

<div class="container">

    <div class="box">

        <h1>Welcome</h1>

        <p>
            <?php echo $_SESSION['name']; ?>
        </p>

        <h3>Choose Dashboard</h3>

        <a href="student_dashboard.php" class="btn">
            Student Dashboard
        </a>

        <a href="dashboard.php" class="btn">
            Rakan Akademik Dashboard
        </a>

    </div>

</div>

</body>
</html>