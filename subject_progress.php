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
        background:#fff;
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
        margin-bottom:25px;
    }

    .progress-container h3{
        color:#2748A5;
        margin-top:25px;
        margin-bottom:15px;
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

    table{
        width:100%;
        border-collapse:collapse;
        margin-top:20px;
    }

    th{
        background:#2748A5;
        color:white;
        padding:15px;
        font-size:16px;
    }

    td{
        padding:15px;
        text-align:center;
        border-bottom:1px solid #ddd;
    }

    tr:nth-child(even){
        background:#f8f8f8;
    }

    tr:hover{
        background:#eef4ff;
    }

    </style>

</head>

<body>

<header class="topbar">

    <div class="logo">
        <img src="images/logoRakan.png" alt="">
        <img src="images/logoUtem.png" alt="">
        <img src="images/logoFtmk.png" alt="">
        <img class="quiz-logo" src="images/quiz.jpg" alt="">
    </div>

    <div class="icons">
        <i class="fas fa-home" onclick="location.href='student_dashboard.php'"></i>
        <i class="far fa-user-circle" onclick="location.href='profile.php'"></i>
    </div>

</header>

<div class="menu-bar">
    <a href="student_progress.php" class="active-menu">Progress Tracker</a>
</div>

<div class="main-content">

    <div class="progress-container">

        <h2><?php echo htmlspecialchars($subject); ?> Progress</h2>

        <p>View detailed progress for this subject.</p>

        <div class="summary-box">

            <h3>Subject Summary</h3>

            <p><strong>Quiz Attempt :</strong> 8</p>

            <p><strong>Highest Score :</strong> 95%</p>

            <p><strong>Average Score :</strong> 82%</p>

        </div>

        <h3>Quiz History</h3>

        <table>

            <tr>
                <th>Quiz</th>
                <th>Score</th>
                <th>Status</th>
            </tr>

            <tr>
                <td>Quiz 1</td>
                <td>95%</td>
                <td>Completed</td>
            </tr>

            <tr>
                <td>Quiz 2</td>
                <td>82%</td>
                <td>Completed</td>
            </tr>

            <tr>
                <td>Quiz 3</td>
                <td>75%</td>
                <td>Completed</td>
            </tr>

        </table>

    </div>

</div>

</body>
</html>