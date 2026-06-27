<?php
session_start();
include("db_connect.php");

$sql = mysqli_query($conn,
"SELECT * FROM rakan_profile ORDER BY name ASC");
?>

<!DOCTYPE html>
<html>

<head>

    <title>Rakan Akademik</title>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<body>
<div class="navbar-custom">

    <div class="logo-section">
        <img src="images/logoRakan.png">
        <img src="images/logoUtem.png">
        <img src="images/logoFtmk.png">
    </div>

    <div class="icon-section">

        <div class="home-btn"
             onclick="location.href='student_dashboard.php'">
            <i class="fas fa-home"></i>
        </div>

        <a href="profile.php" class="profile-link">
            <div class="profile-icon">
                <i class="fa-regular fa-user"></i>
            </div>
        </a>

    </div>

</div>

    <div class="main-panel">
        <div class="title">
            Rakan Akademik
        </div>

        <div class="subtitle">
            Kindly, please choose Rakan Akademik
        </div>

        <?php
        
        if(mysqli_num_rows($sql) > 0){

            while($row = mysqli_fetch_assoc($sql))

        {
        ?>
        
        <a href="student_viewrakan.php?id=
        
        <?php echo $row['profileID']; ?>" class="student-card">
            <i class="fa-regular fa-user"></i>
            
            <div class="student-name"> <?php echo $row['name']; ?> </div>
        </a>
        <?php
        }
        }
        else{
        ?>
        
        <div class="student-card"> No Rakan Akademik Available </div>
        
        <?php
        
        }
        ?>
    </div>
</body>
</html>