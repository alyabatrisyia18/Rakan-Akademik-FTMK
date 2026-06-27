<?php
session_start();
include("db_connect.php");

$sql = "
SELECT
p.paymentID,
p.payment_date,
p.paymentStatus,

tr.subject,
tr.sessionDate,
tr.hours,
tr.proofFile,

u.name,

p.amount

FROM payment p

JOIN `teaching record` tr
ON p.recordID = tr.recordID

JOIN tutor t
ON tr.matricNoTutor = t.matricNoTutor

JOIN user u
ON t.userID = u.userID

ORDER BY p.payment_date DESC
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Payment History</title>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="header">

        <div class="header-left">

            <img src="images/logoRakan.png"
                class="header-logo">

            <img src="images/logoUtem.png"
                class="header-logo">

            <img src="images/logoFtmk.png"
                class="header-logo">

        </div>

        <div class="header-icons">

            <i class="far fa-user-circle"></i>

            <i class="fas fa-home"
                onclick="location.href='admin_dashboard.php'"></i>

        </div>

    </div>


    <div id="sidebar" class="sidebar">

        <div class="menu-btn" onclick="toggleSidebar()">
            ☰
        </div>

        <h2>Admin</h2>

        <nav>

            <ul>

                <li>
                    <a href="paymentapproval.php">
                        Payment Approval
                    </a>
                </li>

                <li>
                    <a href="paymenthistory.php"
                        class="active-menu">
                        Payment History
                    </a>
                </li>

            </ul>

        </nav>

    </div>



    <div class="content">

        <h1>Payment History</h1>

        <table>

            <tr>

                <th>Tutor</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Hours</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Proof</th>
                <th>Status</th>

            </tr>

            <?php
            while ($row = mysqli_fetch_assoc($result)) {
            ?>

                <tr>

                    <td><?php echo $row['name']; ?></td>

                    <td><?php echo $row['subject']; ?></td>

                    <td><?php echo date("d/m/Y", strtotime($row['sessionDate'])); ?></td>

                    <td><?php echo $row['hours']; ?></td>

                    <td>
                        RM <?php echo number_format($row['amount'], 2); ?>
                    </td>
                    <td>
                        <?php echo date("d/m/Y", strtotime($row['payment_date'])); ?>
                    </td>

                    <td>

                        <a href="viewproofhistory.php?file=<?php echo $row['proofFile']; ?>">
                            View Proof
                        </a>

                    </td>

                    <td>
                        <?php

                        if ($row['paymentStatus'] == "Paid") {

                        ?>

                            <span class="approved">
                                PAID
                            </span>

                        <?php

                        } else {

                        ?>

                            <span class="reject">
                                REJECTED
                            </span>

                        <?php

                        }

                        ?>

                    </td>

                </tr>

            <?php
            }
            ?>

        </table>

    </div>

    <script>
        function toggleSidebar() {

            document.getElementById("sidebar").classList.toggle("collapsed");

        }
    </script>

</body>

</html>