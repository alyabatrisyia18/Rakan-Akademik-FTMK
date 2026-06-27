<?php

session_start();
include('db_connect.php');
$matricNoTutor = $_SESSION['matric'];
$sql = "
SELECT *
FROM `teaching record`
WHERE matricNoTutor='$matricNoTutor'
AND submitDate IS NOT NULL
ORDER BY submitDate DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>

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
            <i class="far fa-user-circle"></i>
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
                <li><a href="addtutoringsession.php">Add Tutoring Session</a></li>
                <li><a href="mytutoringsession.php">My Tutoring Session</a></li>
                <li><a href="teachingsessionrecord.php">Add Teaching Session</a></li>
                <li><a href="sessionrecord.php" class="active-menu">Session Record</a></li>
                <li><a href="earningdashboard.php">Earnings Dashboard</a></li>
            </ul>
        </nav>

    </div>
    <div class='content'>
        <h1>Session Record</h1>
        <table>
            <tr>
                <th>DATE</th>
                <th>SUBJECT</th>
                <th>HOURS</th>
                <th>EARNINGS</th>
                <th>STATUS</th>
            </tr><?php while ($row = mysqli_fetch_assoc($result)) { ?><tr>
                    <td><?php echo date('d/m/Y', strtotime($row['sessionDate'])); ?></td>
                    <td><?php echo $row['subject']; ?></td>
                    <td><?php echo $row['hours']; ?></td>
                    <td>RM <?php echo number_format($row['estimatedEarning'], 2); ?></td>
                    <td>

                        <?php
                        if ($row['approvalStatus'] == 'Approved') {
                        ?>
                            <span class="approved">APPROVED</span>

                        <?php
                        } elseif ($row['approvalStatus'] == 'Rejected') {
                        ?>
                            <span class="reject">REJECTED</span>

                        <?php
                        } else {
                        ?>
                            <span class="pending">PENDING</span>

                        <?php
                        }
                        ?>

                    </td>
                </tr><?php } ?>
        </table>
        <p>Note : Sessions marked as pending are waiting admin review before being approved for payment</p>
    </div>
</body>

</html>