<?php
$subject = isset($_GET['subject']) ? $_GET['subject'] : "Subject";
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($subject); ?> Progress</title>

    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>

    body{
        background:url('images/edubackground.jpg');
    }

    .main-content{
        width:85%;
        margin:30px auto;
    }

    .progress-container{
        background:white;
        border-radius:15px;
        padding:30px;
        box-shadow:0 3px 10px rgba(0,0,0,0.15);
    }

    .progress-container h2{
        color:#2748A5;
        text-align:center;
        margin-bottom:10px;
    }

    .progress-container p{
        text-align:center;
        color:#666;
    }

    .summary-box{
        width:350px;
        background:#EEF3FA;
        border-left:5px solid #2748A5;
        border-radius:8px;
        padding:20px;
        margin:30px auto;
        text-align:center;
    }

    .summary-box h3{
        color:#2748A5;
        margin-bottom:15px;
    }

    .summary-box p{
        margin:10px 0;
        color:#333;
    }

    </style>

</head>

<body>

<header class="topbar">

    <div class="logo">
        <img src="images/logoRakan.png">
        <img src="images/logoUtem.png">
        <img src="images/logoFtmk.png">
        <img class="quiz-logo" src="images/quiz.jpg">
    </div>

    <div class="icons">
        <i class="fas fa-home" onclick="location.href='student_dashboard.php'"></i>
        <i class="far fa-user-circle" onclick="location.href='profile.php'"></i>
    </div>

</header>

<div class="menu-bar">
    <a href="student_progress.php" class="active-menu">Progress Tracker</a>
</div>

<<div class="progress-container">

    <h2><?php echo htmlspecialchars($subject); ?> Progress</h2>

    <p>
        View detailed progress for this subject.
    </p>

    <div class="summary-box">

        <h3>Subject Summary</h3>

        <p><strong>Quiz Attempt :</strong> 8</p>

        <p><strong>Highest Score :</strong> 95%</p>

        <p><strong>Average Score :</strong> 82%</p>

    </div>

</div>

</body>
</html>