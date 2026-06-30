<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['matric'])) {
    header("Location:login.php");
    exit();
}

$sql = mysqli_query($conn, "
SELECT tutor.*, user.name
FROM tutor
INNER JOIN user
ON tutor.matricNoTutor=user.matricNoStudent
ORDER BY user.name ASC
");

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Rakan Akademik</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial;
            background: url('images/edubackground.jpg');
            background-size: cover;
        }

        .container {

            width: 1000px;
            margin: 40px auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, .2);
        }
        .main-panel {
            width: 1200px;
            margin: 40px auto;
            background: white;
            border-radius: 15px;
            padding: 45px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);

        }

        .title {

            text-align: center;
            font-size: 42px;
            color: #2748A5;
            font-weight: bold;
        }

        .subtitle {

            text-align: center;
            color: #555;
            margin-top: 12px;
            margin-bottom: 40px;
            font-size: 18px;
        }

        .card {

            display: flex;
            justify-content: space-between;
            align-items: center;

            background: #f4f7ff;

            padding: 25px 30px;

            border-radius: 12px;

            margin-bottom: 20px;

            transition: .3s;
        }

        .card:hover {

            background: #dfe8ff;
        }

        .name {

            font-size: 22px;

            font-weight: bold;

            color: #2748A5;
        }

        .programme {

            color: #666;
            font-size: 17px;
            margin-top: 8px;
        }

        .btn {

            background: #2748A5;

            color: white;

            padding: 12px 28px;

            border-radius: 7px;

            text-decoration: none;
            font-size: 16px;
        }

        .btn:hover {

            background: #18357d;
        }

        .back {

            text-align: center;
            margin-top: 40px;
        }

        .back a {

            text-decoration: none;

            color: white;

            background: #2748A5;

            padding: 12px 30px;

            border-radius: 6px;
        }
    </style>

</head>

<body>

    <div class="main-panel">

        <div class="title">
            Rakan Akademik
        </div>

        <div class="subtitle">
            Choose Your Preferred Tutor
        </div>

        <?php
        if (mysqli_num_rows($sql) > 0) {
            while ($row = mysqli_fetch_assoc($sql)) {
        ?>

                <div class="card">
                    <div>
                        <div class="name">
                            <?php echo $row['name']; ?>
                        </div>

                        <div class="programme">
                            <?php echo $row['programme']; ?>
                        </div>

                    </div>

                    <a
                        class="btn" href="student_viewrakan.php?id=<?php echo $row['matricNoTutor']; ?>">
                        View
                    </a>
                </div>
        <?php

        }
        } else {
            echo "<h3 align='center'>No Tutor Available</h3>";
        }

        ?>
        <div class="back">
            <a href="student_dashboard.php">
                Back
            </a>
        </div>
    </div>

</body>

</html>