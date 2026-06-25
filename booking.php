<?php
session_start();
include("db_connect.php");

$matricNoStudent = $_SESSION['matric'];

if(isset($_POST['bookSession']))
{
    $bookingID = "B" . rand(100,999);

    $recordID = $_POST['recordID'];
    $matricNoTutor = $_POST['matricNoTutor'];
    $subject = $_POST['subject'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

    $schedule = date("Y-m-d H:i:s");

    $insert = "INSERT INTO booking
    (
        bookingID,
        matricNoTutor,
        matricNoStudent,
        schedule,
        bookingStatus,
        subject,
        startTime,
        endTime,
        recordID
    )
    VALUES
    (
        '$bookingID',
        '$matricNoTutor',
        '$matricNoStudent',
        '$schedule',
        'Booked',
        '$subject',
        '$startTime',
        '$endTime',
        '$recordID'
    )";

    mysqli_query($conn,$insert);

    echo "
    <script>
        alert('Booking Successful!');
        window.location='booking.php';
    </script>";
}

$sql = "SELECT *
        FROM `teaching record`
        INNER JOIN tutor
        ON `teaching record`.matricNoTutor = tutor.matricNoTutor
        INNER JOIN user
        ON tutor.userID = user.userId
        WHERE teachingStatus='Available'";

$result = mysqli_query($conn,$sql);

$pastSql = "SELECT *
            FROM booking
            INNER JOIN tutor
            ON booking.matricNoTutor = tutor.matricNoTutor
            INNER JOIN user
            ON tutor.userID = user.userId
            WHERE booking.matricNoStudent='$matricNoStudent'";

$pastResult = mysqli_query($conn,$pastSql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Book Tutoring Session</title>

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

        <i class="fas fa-home"
           onclick="location.href='dashboard.php'"
           title="Dashboard"></i>

    </div>

</div>

<div id="sidebar" class="sidebar">

    <div class="menu-btn" onclick="toggleSidebar()">
        ☰
    </div>

    <h2>Student/Tutor</h2>

    <nav>
        <ul>

            <li>
                <a href="booking.php" class="active-menu">
                    Booking Class
                </a>
            </li>

            <li>
                <a href="myclassschedule.php">
                    My Class Schedule
                </a>
            </li>

            <li>
                <a href="#">
                    Logout
                </a>
            </li>

        </ul>
    </nav>

</div>

<div class="content">

    <h1>Book Tutoring Session</h1>

    <div class="tab">

        <span id="upcomingTab"
              class="active-tab"
              onclick="showUpcoming()">

            Upcoming

        </span>

        <span id="bookingtab"
              onclick="showBookings()">

            My Bookings

        </span>

    </div>

    <div id="upcomingTable">

        <table>

            <tr>

                <th>DATE & TIME</th>
                <th>SUBJECT</th>
                <th>TUTOR NAME</th>
                <th>ACTION</th>

            </tr>

            <?php
            while($row = mysqli_fetch_assoc($result))
            {
                $recordID = $row['recordID'];

                $isTutorSession =
                    ($matricNoStudent == $row['matricNoTutor']);

                $checkBooking = mysqli_query(
                    $conn,
                    "SELECT *
                    FROM booking
                    WHERE recordID='$recordID'
                    AND matricNoStudent='$matricNoStudent'"
                );

                $alreadyBooked = mysqli_num_rows($checkBooking);

                $countSql = "SELECT COUNT(*) AS total
                             FROM booking
                             WHERE recordID='$recordID'";

                $countResult = mysqli_query($conn,$countSql);

                $countRow = mysqli_fetch_assoc($countResult);

                $totalStudent = $countRow['total'];
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

                    <form method="POST">

                        <input
                        type="hidden"
                        name="recordID"
                        value="<?php echo $row['recordID']; ?>">

                        <input
                        type="hidden"
                        name="matricNoTutor"
                        value="<?php echo $row['matricNoTutor']; ?>">

                        <input
                        type="hidden"
                        name="subject"
                        value="<?php echo $row['subject']; ?>">

                        <input
                        type="hidden"
                        name="startTime"
                        value="<?php echo $row['startTime']; ?>">

                        <input
                        type="hidden"
                        name="endTime"
                        value="<?php echo $row['endTime']; ?>">

                        <?php
                        if($isTutorSession)
                        {
                        ?>

                            <button
                            type="button"
                            class="available"
                            onclick="alert('You are the tutor for this session. You cannot attend your own class.')">

                                ATTEND

                            </button>

                        <?php
                        }
                        elseif($alreadyBooked > 0)
                        {
                        ?>

                            <button
                            type="button"
                            class="attended"
                            disabled>

                                ATTENDED

                            </button>

                        <?php
                        }
                        else
                        {
                        ?>

                            <button
                            type="submit"
                            name="bookSession"
                            class="available">

                                ATTEND

                            </button>

                        <?php
                        }
                        ?>

                        <span class="student-count">
                            👥 <?php echo $totalStudent; ?>/10
                        </span>

                    </form>

                </td>

            </tr>

            <?php
            }
            ?>

        </table>

    </div>

    <div id="bookings" style="display:none;">

        <table>

            <tr>

                <th>BOOKING ID</th>
                <th>SUBJECT</th>
                <th>TUTOR</th>
                <th>STATUS</th>

            </tr>

            <?php
            while($pastRow = mysqli_fetch_assoc($pastResult))
            {
            ?>

            <tr>

                <td>
                    <?php echo $pastRow['bookingID']; ?>
                </td>

                <td>
                    <?php echo $pastRow['subject']; ?>
                </td>

                <td>
                    <?php echo $pastRow['matricNoTutor']; ?>
                </td>

                <td>

                    <button class="completed">

                        <?php
                        echo $pastRow['bookingStatus'];
                        ?>

                    </button>

                </td>

            </tr>

            <?php
            }
            ?>

        </table>

    </div>

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

function showBookings()
{
    document.getElementById("upcomingTable").style.display = "none";
    document.getElementById("bookings").style.display = "block";

    document.getElementById("upcomingTab").classList.remove("active-tab");
    document.getElementById("bookingtab").classList.add("active-tab");
}

function showUpcoming()
{
    document.getElementById("upcomingTable").style.display = "block";
    document.getElementById("bookings").style.display = "none";

    document.getElementById("bookingtab").classList.remove("active-tab");
    document.getElementById("upcomingTab").classList.add("active-tab");
}

</script>

</body>
</html>