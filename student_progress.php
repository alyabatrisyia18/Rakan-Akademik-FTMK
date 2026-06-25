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
    font-weight:bold;
    font-size:18px;
    }

    .high{
        color:#28a745;
    }

    .medium{
        color:#0d47a1;
    }

    .low{
        color:#ffc107;
    }

    .fail{
        color:#dc3545;
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
    <a href="progress.php" class="active-menu">Progress Tracker</a>
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

            <tr>
                <td>Programming</td>
                <td>8</td>
                <td>95%</td>
                <td>82%</td>
            </tr>

            <tr>
                <td>Data Structure & Algorithm</td>
                <td>6</td>
                <td>88%</td>
                <td>75%</td>
            </tr>

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