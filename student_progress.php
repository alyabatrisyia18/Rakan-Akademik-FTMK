<?php
include("db_connect.php");

$sql = "SELECT
            q.category,
            COUNT(qa.attemptID) AS total_attempt,
            MAX(qa.score) AS highest_score,
            ROUND(AVG(qa.score),0) AS average_score

        FROM quiz_attempts qa

        JOIN quiz q
        ON qa.quizID = q.quizID

        GROUP BY q.category

        ORDER BY q.category";

$result = mysqli_query($conn, $sql);
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

        <h2>Progress Overview</h2>

        <p>View your quiz performance for each subject.</p>

        <table>

            <tr>
                <th>Subject</th>
                <th>Quiz Attempt</th>
                <th>Highest Score</th>
                <th>Average Score</th>
            </tr>

          <?php
while($row = mysqli_fetch_assoc($result))
{
?>
<tr>

    <td>
        <a href="subject_progress.php?subject=<?php echo urlencode($row['category']); ?>" class="subject-link">
            <?php echo $row['category']; ?>
        </a>
    </td>

    <td><?php echo $row['total_attempt']; ?></td>

    <td>
        <span class="score high">
            <?php echo $row['highest_score']; ?>%
        </span>
    </td>

    <td>
        <span class="score medium">
            <?php echo $row['average_score']; ?>%
        </span>
    </td>

</tr>
<?php
}
?>
        </table>

        <div class="overall-box">

            <h3>Overall Summary</h3>

            <p><strong>Total Quiz :</strong> 14</p>

            <p><strong>Overall Average :</strong> 79%</p>

            <p><strong>Best Subject :</strong> Programming</p>

        </div>

    </div>

</div>

</body>
</html>