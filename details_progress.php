<?php
session_start();
include("db_connect.php");
$studentID = $_GET['student'];
$quizID = $_GET['quiz'];

$sql = "SELECT
            qa.user_answer,
            q.title,
            q.category

        FROM quiz_attempts qa

        INNER JOIN quiz q
        ON qa.quizID = q.quizID

        WHERE qa.matricNoStudent='$studentID'
        AND qa.quizID='$quizID'

        ORDER BY qa.attemptID DESC

        LIMIT 1";

$attempt = mysqli_query($conn,$sql);

$attemptData = mysqli_fetch_assoc($attempt);

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

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Student Progress Details</title>

<link rel="stylesheet" href="style2.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
    box-shadow:0 3px 10px rgba(0,0,0,.15);
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
}

th{
    background:#2748A5;
    color:white;
    padding:15px;
}

td{
    padding:15px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

tr:nth-child(even){
    background:#f7f7f7;
}

tr:hover{
    background:#eef4ff;
}

.back-btn{
    text-align:center;
    margin-top:30px;
}

.back-btn a{
    background:#2748A5;
    color:white;
    text-decoration:none;
    padding:12px 25px;
    border-radius:8px;
}

.back-btn a:hover{
    background:#1b3275;
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

</header>

<div class="main-content">

<div class="progress-container">

<h2>Student Progress Details</h2>

<p>View student quiz performance.</p>

<h3>

Quiz :
<?php echo $attemptData['title']; ?>

</h3>

<p>

Subject :
<b><?php echo $attemptData['category']; ?></b>

</p>

<table>

<tr>

    <th>No</th>

    <th>Question</th>

    <th>Your Answer</th>

    <th>Correct Answer</th>

    <th>Status</th>

</tr>

<?php

$no=1;

while($question=mysqli_fetch_assoc($resultQuestion))
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
?>

<tr>

<td>

<?php echo $no++; ?>

</td>

<td>

<?php echo $question['question']; ?>

</td>

<td>
<?php echo $studentAnswerText; ?>

</td>

<td>

<?php

switch($question['correct_answer'])
{
    case "A":
        echo $question['optionA'];
        break;

    case "B":
        echo $question['optionB'];
        break;

    case "C":
        echo $question['optionC'];
        break;

    case "D":
        echo $question['optionD'];
        break;
}

?>

</td>

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

    <a href="tutor_progress.php">

        <i class="fas fa-arrow-left"></i>
        Back

    </a>

</div>

</div>

</div>

</body>

</html>