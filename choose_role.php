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
        background:#f4f8ff;
    }

    .container{
        height:100vh;
        display:flex;
        justify-content:center;
        align-items:center;
    }

    .box{
        background:white;
        padding:50px;
        border-radius:15px;
        width:450px;
        text-align:center;
        box-shadow:0 5px 15px rgba(0,0,0,0.15);
    }

    h1{
        color:#2748A5;
        margin-bottom:10px;
    }

    p{
        color:#666;
        margin-bottom:30px;
    }

    .btn{
        display:block;
        width:100%;
        padding:15px;
        margin-bottom:15px;
        text-decoration:none;
        background:#6CB6E9;
        color:white;
        border-radius:8px;
        font-size:16px;
    }

    .btn:hover{
        background:#4ea3dd;
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

        <a href="dashboard.php" class="btn">
            Student Dashboard
        </a>

        <a href="rakan_dashboard.php" class="btn">
            Rakan Akademik Dashboard
        </a>

    </div>

</div>

</body>
</html>