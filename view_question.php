<?php
session_start();
include("db_connect.php");

$studentID = $_SESSION['matric'];
$attemptID = $_GET['attempt'];

$sql = "SELECT
            qa.user_answer,
            qa.quizID,
            q.title,
            q.category

        FROM quiz_attempts qa

        INNER JOIN quiz q
        ON qa.quizID = q.quizID

        WHERE qa.attemptID='$attemptID'
        AND qa.matricNoStudent='$studentID'

        LIMIT 1";

$attempt = mysqli_query($conn,$sql);

$attemptData = mysqli_fetch_assoc($attempt);

if(!$attemptData)
{
    die("No quiz attempt found.");
}

$quizID = $attemptData['quizID'];

$userAnswer = json_decode($attemptData['user_answer'],true);

$sqlQuestion = "SELECT *

FROM quiz_question

WHERE quizID='$quizID'

ORDER BY questionID";

$resultQuestion = mysqli_query($conn,$sqlQuestion);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Question Review</title>

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

    .view-btn{

display:inline-block;
background:#2748A5;
color:#fff;
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

.status{

font-weight:bold;

}

.completed{

color:#28a745;

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

       <h2>Question Review</h2>

<p>Review your quiz answers.</p>

      <div class="summary-box">

<h3>Quiz Information</h3>

<p>
<strong>Quiz :</strong>
<?php echo $attemptData['title']; ?>
</p>

<p>
<strong>Subject :</strong>
<?php echo $attemptData['category']; ?>
</p>

</div>
    
<h3>Question Review</h3>

<table>

<tr>

<th>No</th>

<th>Question</th>

<th>Your Answer</th>

<th>Correct Answer</th>

<th>Status</th>

</tr>

<?php

$no = 1;

while($question = mysqli_fetch_assoc($resultQuestion))
{

$qid = $question['questionID'];

$studentAnswer = "";

if(isset($userAnswer[$qid]))
{
    $studentAnswer = $userAnswer[$qid];
}

$studentAnswerText = "";

switch($studentAnswer)
{
    case "A":
        $studentAnswerText = $question['optionA'];
        break;

    case "B":
        $studentAnswerText = $question['optionB'];
        break;

    case "C":
        $studentAnswerText = $question['optionC'];
        break;

    case "D":
        $studentAnswerText = $question['optionD'];
        break;
}

$correctAnswerText = "";

switch($question['correct_answer'])
{
    case "A":
        $correctAnswerText = $question['optionA'];
        break;

    case "B":
        $correctAnswerText = $question['optionB'];
        break;

    case "C":
        $correctAnswerText = $question['optionC'];
        break;

    case "D":
        $correctAnswerText = $question['optionD'];
        break;
}

?>

<tr>

<td><?php echo $no++; ?></td>

<td><?php echo $question['question']; ?></td>

<td><?php echo $studentAnswerText; ?></td>

<td><?php echo $correctAnswerText; ?></td>

<td>

<?php

if($studentAnswer == $question['correct_answer'])
{
    echo "<span style='color:green;font-weight:bold;'>✔ Correct</span>";
}
else
{
    echo "<span style='color:red;font-weight:bold;'>✘ Wrong</span>";
}

?>

</td>

</tr>

<?php

}

?>

</table>

       <div class="back-btn">
    <a href="javascript:history.back()">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

    </div>

</div>

</body>
</html>