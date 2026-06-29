<?php
session_start();

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
        body {
            margin: 0;
            font-family: Segoe UI, sans-serif;
            background-image: url('images/edubackground.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box {
            width: 420px;
            background: rgba(255, 255, 255, .9);
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .2);
        }

        h1 {
            color: #1f3f98;
            margin-bottom: 10px;
        }

        p {
            color: #555;
            margin-bottom: 25px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            background: #3fa9f5;
            font-weight: bold;
            transition: .3s;
        }

        .btn:hover {
            background: #1b8ce3;
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

            <a
                href="student_dashboard.php"
                class="btn">

                Student Dashboard

            </a>

            <a
                href="dashboard.php"
                class="btn">

                Rakan Akademik Dashboard

            </a>

        </div>

    </div>

</body>

</html>