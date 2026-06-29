<?php
include("db_connect.php");

$sql = "SELECT *
        FROM tutor_application
        WHERE status='Pending'
        ORDER BY applicationDate DESC";

$result = mysqli_query($conn, $sql);

$sql = "
SELECT
    tutor_application.applicationID,
    tutor_application.matricNoStudent,
    tutor_application.contactNumber,
    tutor_application.programme,
    tutor_application.currentStatus,
    tutor_application.cgpa,
    tutor_application.expertise,
    tutor_application.availability,
    tutor_application.reason,
    tutor_application.transcript,
    tutor_application.status,
    user.name,
    user.email
    FROM tutor_application
    INNER JOIN user
    ON tutor_application.matricNoStudent = user.matricNoStudent
    WHERE tutor_application.status='Pending'
    ORDER BY tutor_application.applicationDate DESC
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <title>Approve Tutor</title>

    <style>
        body {
            font-family: Segoe UI, sans-serif;
            background: #f4f6fb;
            padding: 40px;
        }

        .header {
            background: #2748A5;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            margin: -40px -40px 30px -40px;
        }

        .logo img {
            height: 50px;
            margin-right: 10px;
        }

        .icons i {
            color: white;
            font-size: 30px;
            cursor: pointer;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 95%;
            margin: auto;
            overflow-x: auto;
        }

        h2 {
            text-align: center;
            color: #2748A5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #2748A5;
            color: white;
        }

        .btn {
            padding: 7px 14px;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            margin-bottom: 5px;
        }

        .approve {
            background: green;
        }

        .reject {
            background: red;
        }

        .view-link {
            color: #2748A5;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="logo">
            <img src="images/logoRakan.png" alt="Rakan Akademik Logo">
            <img src="images/logoUtem.png" alt="UTeM Logo">
            <img src="images/logoFtmk.png" alt="FTMK Logo">
        </div>

        <div class="icons">
            <i class="fas fa-home" onclick="location.href='admin_dashboard.php'"></i>
            <i class="far fa-user-circle" onclick="location.href='profile.php'"></i>
        </div>
    </div>

    <div class="container">
        <h2>Tutor Applications</h2>

        <table>
            <tr>
                <th>Matric</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Programme</th>
                <th>CGPA</th>
                <th>Expertise</th>
                <th>Availability</th>
                <th>Current Status</th>
                <th>Transcript</th>
                <th>Application Date</th>
                <th>Action</th>
            </tr>

            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["matricNoStudent"]); ?></td>
                        <td><?php echo htmlspecialchars($row["name"]); ?></td>
                        <td><?php echo htmlspecialchars($row["email"]); ?></td>
                        <td><?= htmlspecialchars($row['contactNumber']); ?></td>
                        <td><?= htmlspecialchars($row['programme']); ?></td>
                        <td><?php echo htmlspecialchars($row["cgpa"]); ?></td>
                        <td><?php echo htmlspecialchars($row["expertise"]); ?></td>
                        <td><?php echo htmlspecialchars($row["availability"]); ?></td>
                        <td><?= htmlspecialchars($row['currentStatus']); ?></td>
                        <td><?php echo htmlspecialchars($row["reason"]); ?></td>

                        <td>
                            <?php
                            if (!empty($row["transcript"])) {
                            ?>
                                <a class="view-link"
                                    href="uploads/<?php echo htmlspecialchars($row["transcript"]); ?>"
                                    target="_blank">
                                    View Transcript
                                </a>
                            <?php
                            } else {
                                echo "-";
                            }
                            ?>
                        </td>

                        <td>
                            <form method="POST" action="approve_reject.php" style="display:inline;">
                                <input type="hidden" name="applicationID" value="<?php echo $row["applicationID"]; ?>">
                                <input type="submit" name="approve" value="Approve" class="btn approve">
                            </form>

                            <form method="POST" action="approve_reject.php" style="display:inline;">
                                <input type="hidden" name="applicationID" value="<?php echo $row["applicationID"]; ?>">
                                <input type="submit" name="reject" value="Reject" class="btn reject">
                            </form>
                        </td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="9" style="text-align:center;"> No Tutor Awaiting Approval</td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>

</body>

</html>