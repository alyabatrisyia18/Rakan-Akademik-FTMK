<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit();
}

$matric = $_SESSION['matric'];
$sqlUser = mysqli_query($conn, "
SELECT *
FROM user
WHERE matricNoStudent='$matric'
");

if (mysqli_num_rows($sqlUser) == 0) {
    die("User not found.");
}

$user = mysqli_fetch_assoc($sqlUser);

$name = $user['name'];
$email = $user['email'];
$phone = $user['mobile_phone'];
$role = trim($user['role']);
$accountStatus = $user['status'];

$roles = array_map('trim', explode(",", $role));

$isTutor = in_array("Tutor", $roles);

if ($isTutor) {

    $dashboard = "choose_role.php";
} else {

    $dashboard = "student_dashboard.php";
}

$programme = "-";
$currentStatus = "-";
$matricDisplay = "-";
$university = "Universiti Teknikal Malaysia Melaka";

if (!$isTutor) {

    $sqlStudent = mysqli_query($conn, "
    SELECT *
    FROM student
    WHERE matricNoStudent='$matric'
    ");

    if (mysqli_num_rows($sqlStudent) > 0) {

        $student = mysqli_fetch_assoc($sqlStudent);

        $programme = $student['course'];

        $matricDisplay = $student['matricNoStudent'];

        // Academic Info ambil daripada table user
        $currentStatus = $user['status'];
    }
} else {

    $sqlTutor = mysqli_query($conn, "
    SELECT *
    FROM tutor
    WHERE matricNoTutor='$matric'
    ");

    if (mysqli_num_rows($sqlTutor) > 0) {

        $tutor = mysqli_fetch_assoc($sqlTutor);

        $programme = $tutor['programme'];

        $currentStatus = $tutor['currentStatus'];

        $matricDisplay = $tutor['matricNoTutor'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
            gap: 18px;
        }

        .icon-btn {
            color: white;
            font-size: 20px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: 0.2s;
            background: rgba(255, 255, 255, 0.1);
            text-decoration: none;
        }

        .icon-btn:hover {
            transform: scale(1.1);
            background: rgba(255, 255, 255, 0.25);
        }

        .bottom-profile-wrapper {
            padding: 30px;
            display: flex;
            justify-content: center;
        }

        .profile-main-container {
            width: 100%;
            max-width: 1300px;
        }

        .profile-card {
            background: white;
            border-radius: 28px;
            padding: 28px 32px;
            display: flex;
            align-items: center;
            gap: 28px;
            flex-wrap: wrap;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(39, 72, 165, 0.2);
            margin-bottom: 32px;
        }

        .profile-info h2 {
            font-size: 1.9rem;
            font-weight: 700;
            color: #111827;
        }

        .profile-info p {
            color: #4b5563;
            font-size: 1.05rem;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .profile-info p i {
            color: #2748A5;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 28px;
        }

        .info-box {
            background: white;
            padding: 24px 26px;
            border-radius: 24px;
            box-shadow: 0 10px 22px -8px rgba(0, 0, 0, 0.08);
            border: 1px solid #eef2ff;
            transition: 0.2s;
        }

        .info-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 28px -12px rgba(0, 0, 0, 0.12);
        }

        .info-box h3 {
            color: #1e3a8a;
            font-size: 1.5rem;
            margin-bottom: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
            border-left: 5px solid #3b82f6;
            padding-left: 16px;
        }

        .info-box p {
            color: #1f2937;
            line-height: 1.65;
            font-size: 1rem;
        }

        .footer-text {
            margin-top: 32px;
            text-align: center;
            font-size: 0.75rem;
            color: #4b5563;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }

        .btn {
            border: none;
            cursor: pointer;
        }

        .logout-container {
            display: flex;
            justify-content: center;
            margin-top: 15px;
            margin-bottom: 20px;
        }

        .logout-btn {
            padding: 10px 20px;
            background: #b91c1c;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background: #991b1b;
        }

        .edit-profile {
            text-align: center;
            margin-bottom: 25px;
        }

        .edit-btn {
            display: inline-block;
            background: #2748A5;
            color: white;
            padding: 10px 24px;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.2s;
        }

        .edit-btn:hover {
            background: #1d3781;
            color: white;
            text-decoration: none;
        }

        @media (max-width:850px) {
            .details-grid {
                grid-template-columns: 1fr;
            }

            .profile-card {
                flex-direction: column;
                text-align: center;
            }
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

            <a href="<?php echo $dashboard; ?>" class="icon-btn" title="Back">
                <i class="fas fa-arrow-left"></i>
            </a>

            <a href="<?php echo $dashboard; ?>" class="icon-btn" title="Home">
                <i class="fas fa-home"></i>
            </a>

            <a href="profile.php" class="icon-btn" title="Profile">
                <i class="far fa-user"></i>
            </a>

        </div>
    </header>

    <div class="bottom-profile-wrapper">
        <div class="profile-main-container">

            <div class="profile-card">

                <div class="profile-info">

                    <h2><?php echo htmlspecialchars($name); ?></h2>

                    <p>
                        <i class="fas fa-user-tag"></i>
                        <?php echo htmlspecialchars($role); ?>
                    </p>

                    <p>
                        <i class="fas fa-envelope"></i>
                        <?php echo htmlspecialchars($email); ?>
                    </p>

                </div>

            </div>

            <div class="edit-profile">

                <a href="profile_edit.php" class="edit-btn">

                    <i class="fas fa-pen"></i>

                    Edit Profile

                </a>

            </div>

            <div class="details-grid">

                <div class="info-box">

                    <h3>

                        <i class="fas fa-address-card"></i>

                        Contact Information

                    </h3>

                    <p>

                        <i class="fas fa-envelope"></i>

                        Email :
                        <?php echo htmlspecialchars($email); ?>

                    </p>

                    <p style="margin-top:12px;">

                        <i class="fas fa-phone"></i>

                        Phone :
                        <?php echo htmlspecialchars($phone); ?>

                    </p>

                </div>

                <div class="info-box">

                    <h3>

                        <i class="fas fa-graduation-cap"></i>

                        Education

                    </h3>

                    <p>

                        Programme :
                        <?php echo htmlspecialchars($programme); ?>

                    </p>

                    <p style="margin-top:12px;">

                        University :
                        Universiti Teknikal Malaysia Melaka

                    </p>

                </div>


                <div class="info-box">

                    <h3>

                        <i class="fas fa-book-open"></i>

                        Academic Information

                    </h3>

                    <p>

                        <?php
                        if ($isTutor) {
                            echo "Tutor Matric Number : ";
                        } else {
                            echo "Student Matric Number : ";
                        }
                        ?>

                        <?php echo htmlspecialchars($matricDisplay); ?>

                    </p>

                    <p style="margin-top:12px;">

                        Current Status :
                        <?php echo htmlspecialchars($currentStatus); ?>

                    </p>

                </div>

                <div class="info-box">

                    <h3>

                        <i class="fas fa-info-circle"></i>

                        Account Status

                    </h3>

                    <p>

                        Role :
                        <strong>

                            <?php echo htmlspecialchars($role); ?>

                        </strong>

                    </p>

                </div>

            </div>

            <div class="logout-container">

                <button
                    class="btn logout-btn"
                    onclick="location.href='logout.php'">

                    <i class="fas fa-sign-out-alt"></i>

                    Logout

                </button>

            </div>

        </div>
    </div>

</body>

</html>