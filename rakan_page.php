<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['matric'])) {
    header("Location:login.php");
    exit();
}

$sql = mysqli_query($conn, "
SELECT *
FROM tutor
ORDER BY name ASC
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

        .title {

            text-align: center;
            font-size: 35px;
            color: #2748A5;
            font-weight: bold;
        }

        .subtitle {

            text-align: center;
            color: #555;
            margin-top: 10px;
            margin-bottom: 35px;
        }

        .card {

            display: flex;
            justify-content: space-between;
            align-items: center;

            background: #f4f7ff;

            padding: 20px;

            border-radius: 10px;

            margin-bottom: 15px;

            transition: .3s;
        }

        .card:hover {

            background: #dfe8ff;
        }

        .name {

            font-size: 18px;

            font-weight: bold;

            color: #2748A5;
        }

        .programme {

            color: #666;

            margin-top: 5px;
        }

        .btn {

            background: #2748A5;

            color: white;

            padding: 10px 20px;

            border-radius: 5px;

            text-decoration: none;
        }

        .btn:hover {

            background: #18357d;
        }

        .back {

            text-align: center;

            margin-top: 30px;
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

    <div class="container">

        <div class="icon-section">

            <div class="home-btn"
                onclick="location.href='student_dashboard.php'">
                <i class="fas fa-home"></i>
            </div>

            <a href="profile.php" class="profile-link">

                <div class="search-box">
                    <input type="text" placeholder="Search">
                    <i class="fa-solid fa-magnifying-glass"></i>

                </div>
                <div class="icon-section">

                    <div class="profile-icon">
                        <i class="fa-regular fa-user"></i>
                    </div>
            </a>

        </div>

    </div>

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

                        class="btn"

                        href="student_viewrakan.php?id=<?php echo $row['matricNoTutor']; ?>">

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