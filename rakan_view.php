<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit();
}

$matricNoTutor = $_SESSION['matric'];

/* Ambil maklumat tutor */

$sql = mysqli_query($conn, "
SELECT *
FROM tutor
WHERE matricNoTutor='$matricNoTutor'
");

if (mysqli_num_rows($sql) == 0) {
    echo "
    <script>

    alert('Tutor profile not found.');

    window.location='dashboard.php';

    </script>
    ";
    exit();
}

$data = mysqli_fetch_assoc($sql);

/* Assign data */

$name = $data['name'];
$programme = $data['programme'];
$institution = $data['institution'];
$currentStatus = $data['currentStatus'];
$academicBackground = $data['academicBackground'];
$academicStrengths = $data['academicStrengths'];
$cgpa = $data['cgpa'];
$expertise = $data['expertise'];
$availability = $data['availability'];
$contactNumber = $data['contactNumber'];
$email = $data['email'];

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Rakan Akademik Profile</title>

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
            color: #2748A5;
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .content {
            display: flex;
            gap: 25px;
        }

        .left,
        .right {
            flex: 1;
            background: #f5f8ff;
            padding: 20px;
            border-radius: 10px;
        }

        p {
            line-height: 1.8;
        }

        .section-title {
            font-weight: bold;
            color: #2748A5;
            margin-top: 20px;
            margin-bottom: 8px;
        }

        .button {
            text-align: center;
            margin-top: 30px;
        }

        .edit-btn {
            background: #2748A5;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        .edit-btn:hover {
            background: #18357d;
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="title">

            Rakan Akademik

        </div>

        <div class="content">

            <div class="left">

                <p>

                    <strong>Name :</strong>

                    <?php echo htmlspecialchars($name); ?>

                </p>

                <p>

                    <strong>Programme :</strong>

                    <?php echo htmlspecialchars($programme); ?>

                </p>

                <p>

                    <strong>Institution :</strong>

                    <?php echo htmlspecialchars($institution); ?>

                </p>

                <p>

                    <strong>Current Status :</strong>

                    <?php echo htmlspecialchars($currentStatus); ?>

                </p>

                <div class="section-title">

                    Academic Background

                </div>

                <p>

                    <?php echo nl2br(htmlspecialchars($academicBackground)); ?>

                </p>

                <div class="section-title">

                    Academic Strengths

                </div>

                <p>

                    <?php echo nl2br(htmlspecialchars($academicStrengths)); ?>

                </p>

            </div>

            <div class="right">

                <p>

                    <strong>CGPA :</strong>

                    <?php echo htmlspecialchars($cgpa); ?>

                </p>

                <p>

                    <strong>Expertise :</strong>

                    <?php echo htmlspecialchars($expertise); ?>

                </p>

                <p>

                    <strong>Availability :</strong>

                    <?php echo nl2br(htmlspecialchars($availability)); ?>

                </p>

                <p>

                    <strong>Contact Number :</strong>

                    <?php echo htmlspecialchars($contactNumber); ?>

                </p>

                <p>

                    <strong>Email :</strong>

                    <?php echo htmlspecialchars($email); ?>

                </p>

            </div>

        </div>

        <div class="button">

            <a href="rakan_form.php">

                <button
                    type="button"
                    class="edit-btn">

                    Edit Profile

                </button>

            </a>

            &nbsp;&nbsp;

            <a href="dashboard.php">

                <button
                    type="button"
                    class="edit-btn">

                    Back

                </button>

            </a>

        </div>

    </div>

</body>

</html>