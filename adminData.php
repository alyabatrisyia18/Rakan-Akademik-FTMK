<?php
include("db_connect.php");
$sqlSubject = "
SELECT
q.category,
ROUND(AVG((qa.score/qa.total_question)*100),2) AS averageScore

FROM quiz_attempts qa

INNER JOIN quiz q
ON qa.quizID=q.quizID

GROUP BY q.category";

$resultSubject = mysqli_query($conn, $sqlSubject);

$labels = [];
$scores = [];

$programmingAverage = 0;
$dsaAverage = 0;

$bestSubject = "";
$highestAverage = 0;

while ($row = mysqli_fetch_assoc($resultSubject)) {
    $labels[] = $row['category'];
    $scores[] = round($row['averageScore'], 2);

    if ($row['category'] == "Programming") {
        $programmingAverage = $row['averageScore'];
    }

    if ($row['category'] == "Data Structure & Algorithm") {
        $dsaAverage = $row['averageScore'];
    }

    if ($row['averageScore'] > $highestAverage) {
        $highestAverage = $row['averageScore'];
        $bestSubject = $row['category'];
    }
}

$sqlPerformance = "
SELECT
SUM(CASE WHEN avgScore < 50 THEN 1 ELSE 0 END) AS weak,
SUM(CASE WHEN avgScore BETWEEN 50 AND 79 THEN 1 ELSE 0 END) AS good,
SUM(CASE WHEN avgScore >= 80 THEN 1 ELSE 0 END) AS excellent
FROM
(
SELECT
qa.matricNoStudent,
AVG((qa.score/qa.total_question)*100) AS avgScore
FROM quiz_attempts qa
GROUP BY qa.matricNoStudent
) performance";

$resultPerformance = mysqli_query($conn, $sqlPerformance);
$performance = mysqli_fetch_assoc($resultPerformance);

$weak = $performance['weak'];
$good = $performance['good'];
$excellent = $performance['excellent'];

$sql = "SELECT matricNoStudent, name, email, mobile_phone, role, status
        FROM user
        WHERE 1=1";

$sql .= " ORDER BY matricNoStudent";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <title>Data Analytics</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-image: url('images/edubackground.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        header {
            background: #1f3f98;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
        }

        .logo img {
            height: 60px;
            width: auto;
        }

        .icons {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .icons i {
            font-size: 26px;
            cursor: pointer;
            color: white;
        }

        .welcome {
            background: #284db6;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .welcome h1 {
            font-size: 32px;
        }

        .container {
            width: 90%;
            margin: 30px auto;
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .graph-container {
            width: 70%;
            margin: 10px auto;
            background: #fff;
            border-radius: 15px;
            padding: 15px;
            height: 520px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .15);
        }

        .graph-summary {
            margin-top: 20px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-wrap: wrap;
        }

        .summary-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin: 8px 15px;
        }

        .color-box {
            width: 18px;
            height: 18px;
            border-radius: 4px;
        }

        .programming {
            background: #8B2F0D;
        }

        .dsa {
            background: #4CAF50;
        }

        .highlight {
            width: 100%;
            text-align: center;
            margin-top: 20px;
            color: #2748A5;
            font-size: 17px;
            font-weight: bold;
        }

        .graph-container h2 {
            color: #284db6;
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }

        #subjectChart {
            width: 100%;
            height: 220px !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #1f3f98;
            color: white;
            padding: 15px;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        tr:nth-child(even) {
            background: #f7f7f7;
        }

        tr:hover {
            background: #eef3ff;
        }

        .view-btn {
            color: #1f3f98;
            font-size: 18px;
            text-decoration: none;
        }

        .summary-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 35px;
        }

        .summary-card {
            flex: 1;
            background: #284db6;
            color: white;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .2);
        }

        .summary-card h3 {
            margin-bottom: 15px;
            font-size: 18px;
        }

        .summary-card p {
            font-size: 30px;
            font-weight: bold;
        }

        .chart-wrapper {
            width: 90%;
            height: 320px;
            margin: 0 auto;
        }

        .pie-wrapper {
            width: 350px;
            height: 350px;
            margin: 30px auto;
        }

        .performance-layout {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 60px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .performance-details {
            min-width: 320px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 25px 0;
            gap: 30px;
        }

        .detail-left {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 17px;
        }

        .detail-right {
            text-align: right;
            font-size: 18px;
        }

        .dot {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: inline-block;
        }

        .dot.weak {
            background: #dc3545;
        }

        .dot.good {
            background: #ffc107;
        }

        .dot.excellent {
            background: #28a745;
        }
    </style>

</head>

<body>

    <header>

        <div class="logo">
            <img src="images/logoRakan.png" alt="Rakan Akademik Logo">
            <img src="images/logoUtem.png" alt="UTeM Logo">
            <img src="images/logoFtmk.png" alt="FTMK Logo">
        </div>

        <div class="icons">
            <i class="fas fa-home" onclick="location.href='admin_dashboard.php'"></i>
        </div>

    </header>

    <section class="welcome">
        <h1>VIEW DATA ANALYTICS</h1>
    </section>

    <section class="container">
        <div class="summary-container">

            <div class="summary-card">
                <h3>Total Students</h3>
                <?php

                $totalStudent = mysqli_query($conn, "
SELECT COUNT(*) total
FROM user
WHERE role LIKE '%Student%'");

                $totalStudent = mysqli_fetch_assoc($totalStudent);

                ?>

                <p><?php echo $totalStudent['total']; ?></p>
            </div>

            <div class="summary-card">
                <h3>Total Tutors</h3>
                <?php

                $totalTutor = mysqli_query($conn, "
SELECT COUNT(*) total
FROM user
WHERE role LIKE '%Tutor%'");

                $totalTutor = mysqli_fetch_assoc($totalTutor);

                ?>

                <p><?php echo $totalTutor['total']; ?></p>
            </div>

            <div class="summary-card">
                <h3>Total Quizzes</h3>
                <?php

                $totalQuiz = mysqli_query($conn, "
SELECT COUNT(*) total
FROM quiz");

                $totalQuiz = mysqli_fetch_assoc($totalQuiz);

                ?>

                <p><?php echo $totalQuiz['total']; ?></p>
            </div>

            <div class="summary-card">
                <h3>Total Attempts</h3>
                <?php

                $totalAttempt = mysqli_query($conn, "
SELECT COUNT(*) total
FROM quiz_attempts");

                $totalAttempt = mysqli_fetch_assoc($totalAttempt);

                ?>

                <p><?php echo $totalAttempt['total']; ?></p>
            </div>

        </div>
        <div class="graph-container">

            <h2>Average Quiz Score by Subject</h2>

            <div class="chart-wrapper">
                <div class="graph-summary">

                    <div class="summary-item">
                        <span class="color-box programming"></span>
                        Programming :
                        <b><?php echo round($programmingAverage); ?>%</b>
                    </div>

                    <div class="summary-item">
                        <span class="color-box dsa"></span>
                        Data Structure & Algorithm :
                        <b><?php echo round($dsaAverage); ?>%</b>
                    </div>

                    <div class="highlight">
                        Highest Average Subject :
                        <b><?php echo $bestSubject; ?></b>
                        (<?php echo $highestAverage; ?>%)
                    </div>

                </div>
                <canvas id="subjectChart"></canvas>
            </div>

        </div>

        <div class="graph-container">

            <h2>Overall Student Performance</h2>

            <div class="performance-layout">

                <div class="pie-wrapper">
                    <canvas id="performanceChart"></canvas>
                </div>

                <div class="performance-details">

                    <div class="detail-row">

                        <div class="detail-left">
                            <span class="dot weak"></span>
                            <span>Weak (0% - 49%)</span>
                        </div>

                        <div class="detail-right">
                            <b><?php echo round(($weak / ($weak + $good + $excellent)) * 100); ?>%</b><br>
                            (<?php echo $weak; ?> Students)
                        </div>

                    </div>

                    <div class="detail-row">

                        <div class="detail-left">
                            <span class="dot good"></span>
                            <span>Good (50% - 79%)</span>
                        </div>

                        <div class="detail-right">
                            <b><?php echo round(($good / ($weak + $good + $excellent)) * 100); ?>%</b><br>
                            (<?php echo $good; ?> Students)
                        </div>

                    </div>

                    <div class="detail-row">

                        <div class="detail-left">
                            <span class="dot excellent"></span>
                            <span>Excellent (80% - 100%)</span>
                        </div>

                        <div class="detail-right">
                            <b><?php echo round(($excellent / ($weak + $good + $excellent)) * 100); ?>%</b><br>
                            (<?php echo $excellent; ?> Students)
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('subjectChart');

        new Chart(ctx, {

            type: 'bar',

            data: {

                labels: <?php echo json_encode($labels); ?>,

                datasets: [{

                    label: 'Average Score (%)',

                    data: <?php echo json_encode($scores); ?>,

                    backgroundColor: ['#7c2e12', '#4CAF50'],

                    borderRadius: 8,
                    barThickness: 140

                }]


            },

            options: {

                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    }
                },

                scales: {

                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            stepSize: 10,
                            font: {
                                size: 14
                            }
                        }
                    },

                    x: {
                        ticks: {
                            font: {
                                size: 14
                            }
                        }
                    }

                }

            }

        });

        const performanceCtx = document.getElementById('performanceChart');

        new Chart(performanceCtx, {

            type: 'pie',

            data: {

                labels: [
                    'Weak',
                    'Good',
                    'Excellent'
                ],

                datasets: [{

                    data: [
                        <?php echo $weak; ?>,
                        <?php echo $good; ?>,
                        <?php echo $excellent; ?>
                    ],

                    backgroundColor: [
                        '#dc3545',
                        '#ffc107',
                        '#28a745'
                    ],

                    borderColor: '#fff',
                    borderWidth: 2

                }]

            },

            options: {

                responsive: true,
                maintainAspectRatio: true,

                plugins: {

                    legend: {
                        display: false
                    },

                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + " : " + context.raw + " Students";
                            }
                        }
                    }

                }

            }

        });
    </script>


</body>

</html>