<?php
include("db_connect.php");

$subject = isset($_GET['subject']) ? $_GET['subject'] : "Subject";
$summary_sql = "SELECT

COUNT(qa.attemptID) AS total_attempt,

ROUND(MAX((qa.score/qa.total_question)*100),0) AS highest_score,

ROUND(AVG((qa.score/qa.total_question)*100),0) AS average_score

FROM quiz_attempts qa

JOIN quiz q
ON qa.quizID=q.quizID

WHERE q.category='$subject'";

$summary_result = mysqli_query($conn,$summary_sql);

$summary = mysqli_fetch_assoc($summary_result);
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

    .back-btn{
        text-align:center;
        margin-top:30px;
    }

    .back-btn a{
        display:inline-block;
        background:#2748A5;
        color:white;
        text-decoration:none;
        padding:12px 25px;
        border-radius:8px;
        font-weight:bold;
        transition:0.3s;
    }

    .back-btn a:hover{
        background:#1d367f;
    }

    .score{
    display:inline-block;
    min-width:55px;
    padding:6px 12px;
    border-radius:15px;
    font-weight:bold;
    font-size:14px;
    text-align:center;
    }

    .high{
        background:#d4edda;
        color:#155724;
    }

    .medium{
        background:#dbeafe;
        color:#1d4ed8;
    }

    .low{
        background:#fff3cd;
        color:#856404;
    }

    .fail{
        background:#f8d7da;
        color:#721c24;
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

           <p>
    <strong>Quiz Attempt :</strong>
    <?php echo $summary['total_attempt']; ?>
</p>

<p>
    <strong>Highest Score :</strong>
    <span class="score high">
        <?php echo $summary['highest_score']; ?>%
    </span>
</p>

<p>
    <strong>Average Score :</strong>
    <span class="score medium">
        <?php echo $summary['average_score']; ?>%
    </span>
</p>
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
                <td><span class="score high">95%</span></td>
                <td>Completed</td>
            </tr>

            <tr>
                <td>Quiz 2</td>
                <td><span class="score medium">82%</span></td>
                <td>Completed</td>
            </tr>

            <tr>
                <td>Quiz 3</td>
                <td><span class="score low">75%</span></td>
                <td>Completed</td>
            </tr>

        </table>

        <div class="back-btn">
            <a href="student_progress.php">
            <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

    </div>

</div>

</body>
</html>