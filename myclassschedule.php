<?php
session_start();
include("db_connect.php");

$matricNoStudent = $_SESSION['matric'];

$sql = "
SELECT b.*, t.sessionDate, t.sessionType,
       t.meetingLink, t.venue
FROM booking b
JOIN `teaching record` t
ON b.recordID = t.recordID
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

    <div class="search-box">
        <input type="text" placeholder="Hinted search text">
        <i class="fas fa-search"></i>
    </div>

    <div class="header-icons">
        <i class="far fa-bookmark"></i>
        <i class="far fa-bell"></i>
        <i class="far fa-user-circle"></i>
        <i class="fas fa-home"
        onclick="location.href='dashboard.php'"></i>
    </div>

</div>

<div id="sidebar" class="sidebar">

    <div class="menu-btn"
    onclick="toggleSidebar()">
        ☰
    </div>

    <h2>Student/Tutor</h2>

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

            <li>
                <a href="mytutoringsession.php">
                    My Tutoring Session
                </a>
            </li>

            <li>
                <a href="addtutoringsession.php">
                    Add Tutoring Session
                </a>
            </li>

            <li>
                <a href="teachingsessionrecord.php">
                    Add Teaching Session
                </a>
            </li>

            <li>
                <a href="sessionrecord.php">
                    Session Record
                </a>
            </li>

            <li>
                <a href="earningsdashboard.php">
                    Earnings Dashboard
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

<h1>My Class Schedule</h1>

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
<?php echo $row['matricNoTutor']; ?>
</td>

<td>

<?php
if($row['sessionType']=="Online")
{
?>

<button
class="available"
onclick="window.open('<?php echo $row['meetingLink']; ?>')">

JOIN

</button>

<?php
}
else
{
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

function showVenue(venue)
{
    alert(
    "This is a Face-to-Face session\n\nVenue: "
    + venue
    );
}

</script>

</body>
</html>