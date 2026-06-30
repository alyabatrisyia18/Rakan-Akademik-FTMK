<?php
session_start();
include("db_connect.php");
$matricNoTutor = $_SESSION['matric'];
$rate = 15;

$sql = "SELECT * FROM `teaching record`
WHERE matricNoTutor='$matricNoTutor'
AND approvalStatus='Approved'
ORDER BY submitDate DESC";

$result = mysqli_query($conn, $sql);

$totalSession = 0;
$totalHours = 0;
$totalEarning = 0;
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
    $totalSession++;
    $totalHours += $row['hours'];
    $totalEarning += $row['estimatedEarning'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Earnings Dashboard</title>
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
            <i class="fas fa-home" onclick="location.href='dashboard.php'"></i>
            <i class="far fa-user-circle" onclick="location.href='profile.php'" title="profile"></i>
        </div>

    </div>

    <!-- SIDEBAR -->

    <div id="sidebar" class="sidebar">

        <div class="menu-btn" onclick="toggleSidebar()">
            ☰
        </div>

        <h2>Tutor</h2>

        <nav>
            <ul>
                <li><a href="addtutoringsession.php">Add Tutoring Session</a></li>
                <li><a href="mytutoringsession.php">My Tutoring Session</a></li>
                <li><a href="teachingsessionrecord.php">Add Teaching Session</a></li>
                <li><a href="sessionrecord.php">Session Record</a></li>
                <li><a href="earningdashboard.php" class="active-menu">Earnings Dashboard</a></li>
            </ul>
        </nav>

    </div>
    <div class="content">
        <h1>Tutor Earnings Dashboard</h1>

        <div class="dashboard-cards">
            <div class="card">
                <h3>Total Sessions</h3>
                <p><?php echo $totalSession; ?></p>
            </div>
            <div class="card">
                <h3>Total Hours</h3>
                <p><?php echo $totalHours; ?></p>
            </div>
            <div class="card">
                <h3>Rate / Hour</h3>
                <p>RM <?php echo $rate; ?></p>
            </div>
            <div class="card">
                <h3>Total Earnings</h3>
                <p>RM <?php echo number_format($totalEarning, 2); ?></p>
            </div>
        </div>

        <h3>Earnings History</h3>

        <table>
            <tr>
                <th>DATE</th>
                <th>SUBJECT</th>
                <th>HOURS</th>
                <th>RATE</th>
                <th>AMOUNT</th>
                <th>APPROVAL DATE</th>
                <th>STATUS</th>
            </tr>

            <?php
            if (count($data) > 0) {
                foreach ($data as $row) {
            ?>
                    <tr>
                        <td><?php echo date("d/m/Y", strtotime($row['sessionDate'])); ?></td>
                        <td><?php echo $row['subject']; ?></td>
                        <td><?php echo $row['hours']; ?> hrs</td>
                        <td>RM <?php echo $rate; ?></td>
                        <td>
                            RM <?php echo number_format($row['estimatedEarning'], 2); ?>
                        </td>

                        <td>
                            <?php
                            if (!empty($row['approvalDate'])) {
                                echo date("d/m/Y", strtotime($row['approvalDate']));
                            } else {
                                echo "-";
                            }
                            ?>
                        </td>

                        <td>
                            <?php
                            if ($row['approvalStatus'] == "Approved") {
                            ?>
                                <button class="approved">APPROVED</button>
                            <?php
                            } else {
                            ?>
                                <button class="reject">REJECTED</button>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="7" style="text-align:center;">
                        No earnings record found.
                    </td>
                </tr>
            <?php
            }
            ?>

            <tr class="total-row">
                <td colspan="5">Total Earnings</td>
                <td colspan="2">
                    RM <?php echo number_format($totalEarning, 2); ?>
                </td>
            </tr>
        </table>
    </div>
    <script>
        function toggleSidebar() {
            const sidebar =
                document.getElementById("sidebar");

            const content =
                document.querySelector(".content");

            sidebar.classList.toggle("collapsed");

            if (sidebar.classList.contains("collapsed")) {
                content.style.marginLeft = "80px";
            } else {
                content.style.marginLeft = "250px";
            }
        }
    </script>

</body>

</html>