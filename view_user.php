<?php
include("db_connect.php");
$matricNoStudent = $_GET['id'];

$sql = "SELECT *
        FROM user
        WHERE matricNoStudent='$matricNoStudent'";
$result = mysqli_query($conn,$sql);

$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<title>User Details</title>

<style>
    *{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background-image:url('images/edubackground.jpg');
    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;
    background-attachment:fixed;
}

header{
    background:#1f3f98;
    color:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 30px;
}

.logo img{
    height:60px;
    width:auto;
}

.welcome{
    background:#284db6;
    color:white;
    text-align:center;
    padding:20px;
}

.welcome h1{
    font-size:32px;
}

.container{
    width:90%;
    margin:30px auto;
    background:white;
    border-radius:15px;
    padding:30px;
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
}

.detail-box{
    width:550px;
    margin:20px auto;
    background:#f8fbff;
    border-left:6px solid #1f3f98;
    border-radius:15px;
    padding:30px;
}

.detail-box h2{
    color:#1f3f98;
    text-align:center;
    margin-bottom:30px;
}

.detail-row{
    display:grid;
    grid-template-columns:180px 1fr;
    align-items:center;
    padding:15px 0;
    border-bottom:1px solid #ddd;
    column-gap:20px;
}

.detail-row:last-child{
    border-bottom:none;
}

.detail-title{
    font-weight:bold;
    color:#1f3f98;
}

.status{
    display:inline-block;
    width:auto;
    padding:6px 18px;
    border-radius:20px;
    color:white;
    font-weight:bold;
    text-align:center;
}

.active{
    background:#28a745;
}

.inactive{
    background:#dc3545;
}

.approved{
    background:#28a745;
}

.pending{
    background:#ffc107;
    color:#333;
}

.back-btn{
    text-align:center;
    margin-top:30px;
}

.back-btn a{
    display:inline-block;
    background:#1f3f98;
    color:white;
    text-decoration:none;
    padding:12px 25px;
    border-radius:8px;
    font-weight:bold;
    transition:.3s;
}

.back-btn a:hover{
    background:#16337d;
}
</style>
</head>

<body>

<header>

    <div class="logo">
        <img src="images/logoRakan.png" alt="Rakan Akademik Logo">
        <img src="images/logoUtem.png" alt="UTeM Logo">
        <img src="images/logoFtmk.png" alt="FTMK Logo">
    </div>

</header>

<section class="welcome">
    <h1>USER DETAILS</h1>
</section>

<section class="container">

<div class="detail-box">

<h2>
    <i class="fas fa-user-circle"></i>
    User Information
</h2>

<div class="detail-row">
    <span class="detail-title">User ID</span>
    <span><?php echo $user['matricNoStudent']; ?></span>
</div>

<div class="detail-row">
    <span class="detail-title">Name</span>
    <span><?php echo $user['name']; ?></span>
</div>

<div class="detail-row">
    <span class="detail-title">Email</span>
    <span><?php echo $user['email']; ?></span>
</div>

<div class="detail-row">
    <span class="detail-title">Phone Number</span>
    <span><?php echo $user['mobile_phone']; ?></span>
</div>

<div class="detail-row">
    <span class="detail-title">Role</span>
    <span><?php echo $user['role']; ?></span>
</div>

<div class="detail-row">
    <span class="detail-title">Status</span>

    <?php
$status = strtolower(trim($user['status']));

if($status == "approved")
{
    $class = "approved";
}
elseif($status == "active")
{
    $class = "active";
}
elseif($status == "pending")
{
    $class = "pending";
}
else
{
    $class = "inactive";
}
?>

<div class="detail-row">

    <span class="status <?php echo $class; ?>">
        <?php echo $user['status']; ?>
    </span>
</div>

</div>

<div class="back-btn">
    <a href="user_list.php">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

</section>

</body>
</html>