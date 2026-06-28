<?php
session_start();
include("db_connect.php");

$matricNoStudent = $_SESSION['matric'];

$sql = "
SELECT
    b.*,
    t.subject,
    t.sessionDate,
    t.startTime,
    t.endTime,
    t.sessionType,
    t.meetingLink,
    t.venue,
    tutor.name
FROM booking b

INNER JOIN `teaching record` t
ON b.recordID = t.recordID

INNER JOIN tutor
ON b.matricNoTutor = tutor.matricNoTutor

WHERE b.matricNoStudent='$matricNoStudent'
AND b.bookingStatus='Booked'

ORDER BY t.sessionDate ASC
";

$result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Class Schedule</title>

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
            <i class="far fa-user-circle" onclick="location.href='profile.php'"></i>
            <i class="fas fa-home"
                onclick="location.href='student_dashboard.php'"></i>
        </div>

    </div>

    <div id="sidebar" class="sidebar">

        <div class="menu-btn"
            onclick="toggleSidebar()">
            ☰
        </div>

        <h2>Studenta</h2>

        <nav>

            <ul>

                <li>
                    <a href="booking.php">
                        Booking Class
                    </a>
                </li>

                <li>
                    <a href="myclassschedule.php"
                        class="active-menu">
                        My Class Schedule
                    </a>
                </li>

                

            </ul>

        </nav>

    </div>

    <div class="content">

        <h1>My Class Schedule</h1>

        <table>

            <tr>
                <th>DATE & TIME</th>
                <th>SUBJECT</th>
                <th>TUTOR NAME</th>
                <th>ACTION</th>
            </tr>

            <?php
            while ($row = mysqli_fetch_assoc($result)) {
            ?>

                <tr>

                    <td>

                        <?php
                        echo date(
                            "d F Y",
                            strtotime($row['sessionDate'])
                        );
                        ?>

                        <br>

                        <small>

                            <?php
                            echo date(
                                "h:i A",
                                strtotime($row['startTime'])
                            );
                            ?>

                            -

                            <?php
                            echo date(
                                "h:i A",
                                strtotime($row['endTime'])
                            );
                            ?>

                        </small>

                    </td>

                    <td>
                        <?php echo $row['subject']; ?>
                    </td>

                    <td>
                        <?php echo $row['name']; ?>
                    </td>

                    <td>

                        <?php
                        if ($row['sessionType'] == "Online") {
                        ?>

                            <button
                                class="available"
                                onclick="window.open('<?php echo $row['meetingLink']; ?>')">

                                JOIN

                            </button>

                        <?php
                        } else {
                        ?>

                            <button
                                class="available"
                                onclick="showVenue('<?php echo $row['venue']; ?>')">

                                JOIN

                            </button>

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

        function showVenue(venue) {
            alert(
                "This is a Face-to-Face session\n\nVenue: " +
                venue
            );
        }
    </script>

</body>

</html>