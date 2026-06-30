<?php

session_start();
include("db_connect.php");

$matricNoTutor = $_SESSION['matric'];

if (isset($_POST['submitRecord'])) {
    $recordID = $_POST['recordID'];
    $hours = $_POST['hours'];

    $estimatedEarning = $hours * 15;
    $submitDate = date("Y-m-d H:i:s");

    $proofFile = "";

    if (isset($_FILES['proofFile']) && $_FILES['proofFile']['error'] == 0) {
        $proofFile = basename($_FILES['proofFile']['name']);
        move_uploaded_file($_FILES['proofFile']['tmp_name'], "proof/" . $proofFile);
    }

$sql = "UPDATE `teaching record`
SET
proofFile='$proofFile',
hours='$hours',
estimatedEarning='$estimatedEarning',
approvalStatus='Pending',
submitDate='$submitDate'
WHERE recordID='$recordID'";

if(mysqli_query($conn,$sql))
{
    echo "<script>
    alert('Teaching Session Submitted Successfully!');
    window.location='teachingsessionrecord.php';
    </script>";
}
}

$sql = "
SELECT *
FROM `teaching record`
WHERE matricNoTutor='$matricNoTutor'
AND sessionDate <= CURDATE()
AND (approvalStatus IS NULL OR approvalStatus = '')
ORDER BY sessionDate DESC
";

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
            <i class="fas fa-home" onclick="location.href='dashboard.php'"></i>
            <i class="far fa-user-circle" onclick="location.href='profile.php'" title="profile"></i>
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
                <li><a href="teachingsessionrecord.php" class="active-menu" >Add Teaching Session</a></li>
                <li><a href="sessionrecord.php">Session Record</a></li>
                <li><a href="earningdashboard.php">Earnings Dashboard</a></li>
            </ul>
        </nav>

    </div>

    <div class="content">

        <h1>Teaching Session Record</h1>

        <form method="POST" enctype="multipart/form-data" class="session-form">

            <label>Subject</label>

            <select
    name="recordID"
    id="recordID"
    onchange="loadHours()"
    required>

                <option value="">Select Subject</option>

                <?php
while ($row = mysqli_fetch_assoc($result)) {

    $start = strtotime($row['startTime']);
    $end = strtotime($row['endTime']);
    $totalHour = ($end - $start) / 3600;
?>

<option
    value="<?php echo $row['recordID']; ?>"
    data-hour="<?php echo $totalHour; ?>">

    <?php
    echo $row['subject'] . " - " .
    date("d/m/Y", strtotime($row['sessionDate']));
    ?>

</option>

<?php
}
?>

            </select>

            <label>Upload Proof</label>
            <input type="file" name="proofFile" required>

            <label>Hours</label>

            <select name="hours" id="hours" onchange="calculateEarning()" required>

    <option value="">Select Hours</option>

</select>

            <div class="note">
                <h3>Earnings Preview</h3>
                <p>RM15 / hour</p>
                <h2 id="earning">RM0.00</h2>
            </div>

            <div class="button-row">
                <button type="submit" name="submitRecord" class="add-btn">SUBMIT</button>
            </div>

        </form>

    </div>

    <script>
        function calculateEarning() {
            let hour = document.getElementById("hours").value;

            if (hour == "") {
                document.getElementById("earning").innerHTML = "RM0.00";
            } else {
                let total = hour * 15;
                document.getElementById("earning").innerHTML = "RM" + total.toFixed(2);
            }
        }
        function loadHours()
{
    let subject = document.getElementById("recordID");

    let selected = subject.options[subject.selectedIndex];

    let totalHour = selected.getAttribute("data-hour");

    let hour = document.getElementById("hours");

    hour.innerHTML = "<option value=''>Select Hours</option>";

    if(totalHour == null) return;

    for(let i = 1; i <= totalHour; i++)
    {
        hour.innerHTML +=
        "<option value='"+i+"'>"+i+" Hour</option>";
    }

    calculateEarning();
}
    </script>

</body>

</html>