<?php
include("db_connect.php");

if(isset($_POST['addSession']))
{
    $subject = $_POST['subject'];
    $sessionDate = $_POST['sessionDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

    $matricNoTutor = "T001";

    $recordID = "R" . rand(100,999);

    $sql = "INSERT INTO teaching_record
            (recordID, matricNoTutor, subject, sessionDate, teachingStatus, startTime, endTime)
            VALUES
            ('$recordID','$matricNoTutor','$subject','$sessionDate','Available','$startTime','$endTime')";

    mysqli_query($conn,$sql);

    echo "<script>
            alert('Tutoring Session Added Successfully!');
          </script>";
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

        <div class="search-box">
            <input type="text" placeholder="Hinted search text">
            <i class="fas fa-search"></i>
        </div>

        <div class="header-icons">
            <i class="far fa-bookmark"></i>
            <i class="far fa-bell"></i>
            <i class="far fa-user-circle"></i>
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
                <li><a href="booking.php">Booking Class</a></li>
                <li><a href="myclassschedule.php">My Class Schedule</a></li>
                <li><a href="mytutoringsession.php">My Tutoring Session</a></li>
                <li><a href="addtutoringsession.php">Add Tutoring Session</a></li>
                <li><a href="teachingsessionrecord.php">Add Teaching Session</a></li>
                <li><a href="sessionrecord.php">Session Record</a></li>
                <li><a href="earningsdashboard.php">Earnings Dashboard</a></li>
                <li><a href="#">Logout</a></li>
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
                required>

            <div class="time-row">

                <div>

                    <label>Start Time</label>

                    <input
                        type="time"
                        name="startTime"
                        required>

                </div>

                <div>

                    <label>End Time</label>

                    <input
                        type="time"
                        name="endTime"
                        required>

                </div>

            </div>

            <button
                type="submit"
                name="addSession"
                class="add-btn">

                ADD SESSION

            </button>

        </form>

    </div>

    <script>

        function toggleSidebar()
        {
            const sidebar =
                document.getElementById("sidebar");

            const content =
                document.querySelector(".content");

            sidebar.classList.toggle("collapsed");

            if(sidebar.classList.contains("collapsed"))
            {
                content.style.marginLeft = "80px";
            }
            else
            {
                content.style.marginLeft = "250px";
            }
        }

    </script>

</body>

</html>