<?php
session_start();
include("db_connect.php");
$matricNoTutor = $_SESSION['matric'];

if (isset($_POST['addSession'])) {
    $subject = $_POST['subject'];
    $sessionDate = $_POST['sessionDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

    $sessionType = $_POST['sessionType'];

    $meetingLink = !empty($_POST['meetingLink'])
        ? $_POST['meetingLink']
        : '';

    $venue = !empty($_POST['venue'])
        ? $_POST['venue']
        : '';

    if ($sessionType == "Online" && empty($meetingLink)) {
        echo "<script>
        alert('Please enter Meeting Link');
        </script>";
    } elseif ($sessionType == "Face to Face" && empty($venue)) {
        echo "<script>
        alert('Please enter Venue');
        </script>";
    } else {
        // nanti ambil dari login
        $matricNoTutor = $_SESSION['matric'];

        $recordID = "R" . rand(100, 999);

        $sql = "INSERT INTO `teaching record`
        (
            recordID,
            matricNoTutor,
            subject,
            sessionDate,
            teachingStatus,
            startTime,
            endTime,
            sessionType,
            meetingLink,
            venue
        )
        VALUES
        (
            '$recordID',
            '$matricNoTutor',
            '$subject',
            '$sessionDate',
            'Available',
            '$startTime',
            '$endTime',
            '$sessionType',
            '$meetingLink',
            '$venue'
        )";

        if (mysqli_query($conn, $sql)) {
            echo "<script>
            alert('Tutoring Session Added Successfully!');
            </script>";
        } else {
            echo mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Tutoring Session</title>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="header">

        <div class="header-left">

            <img src="images/logoRakan.png"
                alt="Rakan Akademik"
                class="header-logo">

            <img src="images/logoUtem.png"
                alt="UTeM"
                class="header-logo">

            <img src="images/logoFtmk.png"
                alt="FTMK"
                class="header-logo">

        </div>


        <div class="header-icons">
            <i class="far fa-user-circle" onclick="location.href='profile.php'" title="profile"></i>
            <i class="fas fa-home" onclick="location.href='dashboard.php'" title="Dashboard"></i>
        </div>

    </div>

    <!-- SIDEBAR -->

    <div id="sidebar" class="sidebar">

        <div class="menu-btn" onclick="toggleSidebar()">
            ☰
        </div>

        <h2>Student/Tutor</h2>

        <nav>
            <ul>
                <li><a href="addtutoringsession.php" class="active-menu">Add Tutoring Session</a></li>
                <li><a href="mytutoringsession.php">My Tutoring Session</a></li>
                <li><a href="teachingsessionrecord.php">Add Teaching Session</a></li>
                <li><a href="sessionrecord.php">Session Record</a></li>
                <li><a href="earningdashboard.php">Earnings Dashboard</a></li>
            </ul>
        </nav>

    </div>

    <!-- CONTENT -->

    <div class="content">

        <h1>Add Tutoring Session</h1>

        <form method="POST" class="session-form">

            <label>Subject</label>

            <select name="subject" required>
                <option value="">Select Subject</option>
                <option value="Programming">Programming</option>
                <option value="Data Structure and Algorithm">
                    Data Structure and Algorithm
                </option>
            </select>

            <label>Date</label>

            <input
                type="date"
                name="sessionDate"
                min="<?php echo date('Y-m-d'); ?>"
                required>

            <div class="time-row">

                <div>
                    <label>Start Time</label>
                    <input type="time" name="startTime" required>
                </div>

                <div>
                    <label>End Time</label>
                    <input type="time" name="endTime" required>
                </div>
            </div>


            <label>Session Type</label>

            <select
                name="sessionType"
                id="sessionType"
                onchange="toggleSessionType()"
                required>

                <option value="">Select Type</option>
                <option value="Online">Online</option>
                <option value="Face to Face">Face to Face</option>

            </select>

            <div id="onlineSection">

                <label>Meeting Link</label>

                <input
                    type="text"
                    name="meetingLink"
                    placeholder="Paste Teams Link">

            </div>

            <div id="f2fSection" style="display:none;">

                <label>Venue</label>

                <input
                    type="text"
                    name="venue"
                    placeholder="Example: FTMK Discussion Room 2">
            </div>
            <div class="button-row">
                <button
                    type="submit"
                    name="addSession"
                    class="add-btn">

                    ADD SESSION

                </button>
            </div>
        </form>

    </div>

    <script>
        function toggleSessionType() {
            let type =
                document.getElementById("sessionType").value;

            if (type == "Online") {
                document.getElementById("onlineSection").style.display = "block";
                document.getElementById("f2fSection").style.display = "none";
            } else if (type == "Face to Face") {
                document.getElementById("onlineSection").style.display = "none";
                document.getElementById("f2fSection").style.display = "block";
            } else {
                document.getElementById("onlineSection").style.display = "none";
                document.getElementById("f2fSection").style.display = "none";
            }
        }
    </script>

</body>

</html>