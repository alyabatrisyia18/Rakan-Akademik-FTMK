<?php
session_start();
include("db_connect.php");

$matricNoTutor = $_SESSION['matric'];

// Upcoming sessions
$upcomingSql = "
SELECT *
FROM `teaching record`
WHERE matricNoTutor='$matricNoTutor'
AND sessionDate >= CURDATE()
ORDER BY sessionDate ASC
";
$upcomingResult = mysqli_query($conn, $upcomingSql);

// Completed sessions
$completedSql = "
SELECT *
FROM `teaching record`
WHERE matricNoTutor='$matricNoTutor'
AND sessionDate < CURDATE()
ORDER BY sessionDate DESC
";
$completedResult = mysqli_query($conn, $completedSql);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tutoring Session</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="header">
        <div class="header-left">
            <img src="images/logoRakan.png" class="header-logo">
            <img src="images/logoUtem.png" class="header-logo">
            <img src="images/logoFtmk.png" class="header-logo">
        </div>

        <div class="header-icons">
            <i class="far fa-user-circle"></i>
            <i class="fas fa-home" onclick="location.href='dashboard.php'"></i>
        </div>
    </div>

    <div id="sidebar" class="sidebar">
        <div class="menu-btn" onclick="toggleSidebar()">☰</div>

        <h2>Student/Tutor</h2>

        <ul>
            <li><a href="addtutoringsession.php">Add Tutoring Session</a></li>
            <li><a href="mytutoringsession.php" class="active-menu">My Tutoring Session</a></li>
            <li><a href="teachingsessionrecord.php">Add Teaching Session</a></li>
            <li><a href="sessionrecord.php">Session Record</a></li>
            <li><a href="earningdashboard.php">Earnings Dashboard</a></li>
        </ul>
    </div>

    <div class="content">

        <h1>My Tutoring Session</h1>

        <h2>Upcoming Sessions</h2>

        <table>
            <tr>
                <th>DATE</th>
                <th>SUBJECT</th>
                <th>TIME</th>
                <th>SLOT</th>
                <th>ACTION</th>
            </tr>

            <?php
            while ($row = mysqli_fetch_assoc($upcomingResult)) {
                $recordID = $row['recordID'];

                $countSql = "SELECT COUNT(*) AS total FROM booking WHERE recordID='$recordID'";
                $countResult = mysqli_query($conn, $countSql);
                $countRow = mysqli_fetch_assoc($countResult);
                $totalStudent = $countRow['total'];
            ?>
                <tr>
                    <td><?php echo date("d/m/Y", strtotime($row['sessionDate'])); ?></td>
                    <td><?php echo $row['subject']; ?></td>
                    <td><?php echo date("h:i A", strtotime($row['startTime'])) . " - " . date("h:i A", strtotime($row['endTime'])); ?></td>
                    <td><?php echo $totalStudent . "/10"; ?></td>
                    <td><button class="upcoming">UPCOMING</button></td>
                </tr>
            <?php } ?>
        </table>

        <br><br>

        <h2>Completed Sessions</h2>

        <table>
            <tr>
                <th>DATE</th>
                <th>SUBJECT</th>
                <th>TIME</th>
                <th>SLOT</th>
                <th>ACTION</th>
            </tr>

            <?php
            while ($row = mysqli_fetch_assoc($completedResult)) {
                $recordID = $row['recordID'];

                $countSql = "SELECT COUNT(*) AS total FROM booking WHERE recordID='$recordID'";
                $countResult = mysqli_query($conn, $countSql);
                $countRow = mysqli_fetch_assoc($countResult);
                $totalStudent = $countRow['total'];
            ?>
                <tr>
                    <td><?php echo date("d/m/Y", strtotime($row['sessionDate'])); ?></td>
                    <td><?php echo $row['subject']; ?></td>
                    <td><?php echo date("h:i A", strtotime($row['startTime'])) . " - " . date("h:i A", strtotime($row['endTime'])); ?></td>
                    <td><?php echo $totalStudent . "/10"; ?></td>
                    <td><button class="complete">COMPLETE</button></td>
                </tr>
            <?php } ?>
        </table>

    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const content = document.querySelector(".content");

            sidebar.classList.toggle("collapsed");

            if (sidebar.classList.contains("collapsed"))
                content.style.marginLeft = "80px";
            else
                content.style.marginLeft = "250px";
        }
    </script>

</body>

</html>