<?php
session_start();

if(isset($_GET['dashboard']))
{
    $_SESSION['dashboard'] = $_GET['dashboard'];

    if($_GET['dashboard']=="student")
    {
        header("Location: student_dashboard.php");
    }
    else
    {
        header("Location: dashboard.php");
    }

    exit();
}
?>