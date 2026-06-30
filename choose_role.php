<?php
session_start();

if (isset($_SESSION['popupStatus'])) {

    if ($_SESSION['popupStatus'] == "Approved") {

        echo "<script>
        alert('Congratulations! Your tutor application has been approved.');
        </script>";
    } elseif ($_SESSION['popupStatus'] == "Rejected") {

        echo "<script>
        alert('Sorry. Your tutor application has been rejected.');
        </script>";
    }

    unset($_SESSION['popupStatus']);
}

if (!isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit();
}

$roles = array_map('trim', explode(',', $_SESSION['role']));

$hasStudent = in_array("Student", $roles);
$hasTutor = in_array("Tutor", $roles);

if (!$hasStudent || !$hasTutor) {
    if ($hasTutor) {
        header("Location: dashboard.php");
    } else {
        header("Location: student_dashboard.php");
    }

    exit();
}

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Choose Dashboard</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('images/edubackground.jpg') center center/cover no-repeat fixed;
        }

        .container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .box {
            width: 450px;
            background: #ffffff;
            border-radius: 18px;
            padding: 45px 40px;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        h1 {
            color: #184D9A;
            font-size: 32px;
            margin-bottom: 15px;
        }

        p {
            color: #666;
            font-size: 17px;
            margin-bottom: 35px;
            line-height: 1.6;
        }

        p b {
            color: #184D9A;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 16px;
            margin-bottom: 18px;
            border-radius: 12px;
            text-decoration: none;
            color: #fff;
            font-size: 17px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn:first-of-type {
            background: #3B82F6;
        }

        .btn:last-of-type {
            background: #1E40AF;
        }

        .btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
            opacity: .95;
        }

        .btn:active {
            transform: translateY(0);
        }

        @media(max-width:500px) {

            .box {
                width: 95%;
                padding: 35px 25px;
            }

            h1 {
                font-size: 28px;
            }

        }
    </style>

</head>

<body>

    <div class="container">

        <div class="box">

            <h1>Choose Dashboard</h1>

            <p>

                Welcome,

                <b><?php echo $_SESSION['name']; ?></b>

            </p>


            <a href="set_role.php?dashboard=student" class="btn">

                Student Dashboard

            </a>

            <a href="set_role.php?dashboard=tutor" class="btn">

                Rakan Akademik Dashboard

            </a>

        </div>

    </div>

</body>

</html>