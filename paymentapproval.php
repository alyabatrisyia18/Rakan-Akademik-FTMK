<?php
session_start();
include("db_connect.php");

if (isset($_GET['approve'])) {

    $recordID = $_GET['approve'];

    // Update teaching record
    mysqli_query($conn, "
    UPDATE `teaching record`
    SET
    approvalStatus='Approved',
    approvalDate=CURDATE()
    WHERE recordID='$recordID'
    ");

    
    $getRecord = mysqli_query($conn, "
    SELECT estimatedEarning
    FROM `teaching record`
    WHERE recordID='$recordID'
    ");

    $record = mysqli_fetch_assoc($getRecord);


    do {

        $id = rand(100, 999);
        $paymentID = "PAY" . $id;

        $check = mysqli_query($conn, "
        SELECT *
        FROM payment
        WHERE paymentID='$paymentID'
        ");
    } while (mysqli_num_rows($check) > 0);

    // Insert into payment table
    mysqli_query($conn, "
    INSERT INTO payment
    (paymentID,recordID,amount,payment_date,paymentStatus)
    VALUES
    (
    '$paymentID',
    '$recordID',
    '" . $record['estimatedEarning'] . "',
    CURDATE(),
    'Paid'
    )
    ");

    header("Location: paymentapproval.php");
    exit();
}

if (isset($_GET['reject'])) {

    $recordID = $_GET['reject'];

    mysqli_query($conn, "
    UPDATE `teaching record`
    SET
    approvalStatus='Rejected',
    approvalDate=CURDATE()
    WHERE recordID='$recordID'
    ");

    header("Location: paymentapproval.php");
    exit();
}

// Display Pending Payments
$sql = "
SELECT
tr.recordID,
u.name,
tr.subject,
tr.sessionDate,
tr.hours,
tr.estimatedEarning,
tr.proofFile,
tr.approvalStatus

FROM `teaching record` tr

JOIN tutor t
ON tr.matricNoTutor=t.matricNoTutor

JOIN user u
ON t.userID=u.userID

WHERE tr.approvalStatus='Pending'

ORDER BY tr.submitDate ASC
";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Payment Approval</title>

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

            <i class="fas fa-home"
                onclick="location.href='admin_dashboard.php'"
                title="Dashboard"></i>

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
                    <a href="paymentapproval.php" class="active-menu">
                        Payment Approval
                    </a>
                </li>

                <li>
                    <a href="paymenthistory.php">
                        Payment History
                    </a>
                </li>

            </ul>

        </nav>

    </div>

    <div class="content">

        <h1>Payment Approval</h1>

        <table>

            <tr>

                <th>Tutor</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Hours</th>
                <th>Amount</th>
                <th>Proof</th>
                <th>Status</th>
                <th>Action</th>

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
                        RM <?php echo number_format($row['estimatedEarning'], 2); ?>
                    </td>

                    <td>

                        <a href="viewproof.php?file=<?php echo $row['proofFile']; ?>">
                            View Proof
                        </a>

                    </td>

                    <td>

                        <span class="pending">
                            Pending
                        </span>

                    </td>

                    <td>

                        <a href="paymentapproval.php?approve=<?php echo $row['recordID']; ?>"
                            class="approve-btn">
                            Approve
                        </a>

                        <a href="paymentapproval.php?reject=<?php echo $row['recordID']; ?>"
                            class="reject-btn">
                            Reject
                        </a>

                    </td>

                </tr>

            <?php
            }
            ?>

        </table>

    </div>

    <script>
        function toggleSidebar() {

            const sidebar = document.getElementById("sidebar");
            const content = document.querySelector(".content");

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