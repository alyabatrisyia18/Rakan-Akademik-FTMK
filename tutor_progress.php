<?php
session_start();
include("db_connect.php");

/*
   Tukar ikut session login tutor korang
   Contoh:
   $_SESSION['matricNoTutor']
*/

$tutorID = $_SESSION['matric'];

/* ===========================
   Student Performance
=========================== */

$sql = "SELECT

u.matricNoStudent,
u.name,

q.category,

COUNT(qa.attemptID) AS total_attempt,

ROUND(MAX((qa.score/qa.total_question)*100),0) AS highest_score,

ROUND(AVG((qa.score/qa.total_question)*100),0) AS average_score

FROM quiz q

INNER JOIN quiz_attempts qa
ON q.quizID = qa.quizID

INNER JOIN user u
ON qa.matricNoStudent = u.matricNoStudent

WHERE q.matricNoTutor='$tutorID'

GROUP BY
u.matricNoStudent,
u.name,
q.category

ORDER BY u.name";

$result = mysqli_query($conn,$sql);


/* ===========================
   Overall Summary
=========================== */

$summary_sql = "SELECT

COUNT(DISTINCT qa.matricNoStudent) AS total_student,

COUNT(qa.attemptID) AS total_attempt,

ROUND(AVG((qa.score/qa.total_question)*100),0) AS overall_average

FROM quiz q

INNER JOIN quiz_attempts qa
ON q.quizID=qa.quizID

WHERE q.matricNoTutor='$tutorID'";

$summary_result=mysqli_query($conn,$summary_sql);

$summary=mysqli_fetch_assoc($summary_result);


/* ===========================
   Best Subject
=========================== */

$best_sql="SELECT

q.category,

ROUND(AVG((qa.score/qa.total_question)*100),0) AS avg_score

FROM quiz q

INNER JOIN quiz_attempts qa
ON q.quizID=qa.quizID

WHERE q.matricNoTutor='$tutorID'

GROUP BY q.category

ORDER BY avg_score DESC

LIMIT 1";

$best_result=mysqli_query($conn,$best_sql);

$best=mysqli_fetch_assoc($best_result);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Progress Tracker</title>

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
        margin-bottom:10px;
    }

    .progress-container p{
        color:#666;
        margin-bottom:25px;
    }

    table{
        width:100%;
        border-collapse:collapse;
        margin-bottom:25px;
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

    .overall-box{
        width:350px;
        background:#EEF3FA;
        border-left:5px solid #2748A5;
        border-radius:8px;
        padding:20px;
        margin:30px auto;
        text-align:center;;
    }

    .overall-box h3{
        color:#2748A5;
        margin-bottom:15px;
    }

    .overall-box p{
        margin:8px 0;
        color:#333;
    }

    .score{
        display:inline-block;
        min-width:55px;
        padding:6px 12px;
        border-radius:20px;
        font-weight:bold;
        font-size:15px;
        color:white;
        text-align:center;
    }

    .high{
        background:#28a745;
    }

    .medium{
        background:#0d47a1;
    }

    .low{
        background:#ffc107;
        color:#333;
    }

    .fail{
        background:#dc3545;
    }

    .subject-link{
    color:#2748A5;
    text-decoration:underline;
    font-weight:bold;
    transition:0.3s;
    }

    .subject-link:hover{
    color:#1a2f75;
    }

    .view-btn{

    background:#2748A5;
    color:white;
    padding:8px 18px;
    border-radius:8px;
    text-decoration:none;
    font-size:14px;
    font-weight:bold;
    transition:.3s;

}

.view-btn:hover{

    background:#1b3275;

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
    padding:12px 28px;
    border-radius:8px;
    font-weight:bold;
    transition:.3s;
}

.back-btn a:hover{
    background:#1b3275;
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
        <i class="fas fa-home" onclick="location.href='dashboard.php'"></i>
        <i class="far fa-user-circle" onclick="location.href='profile.php'"></i>
    </div>

</header>

<div class="menu-bar">

    <a href="tutor_progress.php" class="active-menu">
        Tutor Progress Tracker
    </a>

</div>
<div class="main-content">

    <div class="progress-container">

        <h2>Tutor Progress Tracker</h2>

<p>
Monitor your students quiz performance and learning progress.
</p>

        <table>

            <tr>

<th>Student ID</th>

<th>Student Name</th>

<th>Subject</th>

<th>Quiz Attempt</th>

<th>Highest Score</th>

<th>Average Score</th>

<th>Action</th>

</tr>
          <?php

while($student = mysqli_fetch_assoc($result))
{

?>

<tr>

<td>

<?php echo $student['matricNoStudent']; ?>

</td>

<td>

<?php echo $student['name']; ?>

</td>

<td>

<?php echo $student['category']; ?>

</td>

<td>

<?php echo $student['total_attempt']; ?>

</td>

<td>

<span class="score high">

<?php echo $student['highest_score']; ?>

</span>

</td>

<td>

<span class="score medium">

<?php echo $student['average_score']; ?>

</span>

</td>

<td>

<a href="tutor_student_progress.php" class="subject-link">

View

</a>

</td>

</tr>

<?php

}

?>
        </table>

        <div class="overall-box">

    <h3>Overall Summary</h3>

    <p>
        <strong>Total Students :</strong>
        <?php echo $summary['total_student']; ?>
    </p>

    <p>
        <strong>Total Quiz Attempts :</strong>
        <?php echo $summary['total_attempt']; ?>
    </p>

    <p>
        <strong>Overall Average :</strong>
        <?php echo $summary['overall_average']; ?>%
    </p>

    <p>
        <strong>Best Subject :</strong>
        <?php echo $best['category']; ?>
    </p>

</div>

<div class="back-btn">

    <a href="quiz.php">

        <i class="fas fa-arrow-left"></i>
        Back

    </a>

</div>
    </div>

</div>

</body>
</html>