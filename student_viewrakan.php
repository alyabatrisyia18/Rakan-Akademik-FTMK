<?php
session_start();
include("db_connect.php");

if(!isset($_SESSION['matric']))
{
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id']))
{
    header("Location: rakan_page.php");
    exit();
}

$id = $_GET['id'];

$sql = mysqli_query($conn,
"SELECT * FROM rakan_profile
WHERE profileID='$id'");

$data = mysqli_fetch_assoc($sql);

if(!$data)
{
    echo "
    <script>
    alert('Profile not found');
    window.location='rakan_page.php';
    </script>
    ";
    exit();
}

$image = "images/default.png";

if(!empty($data['photo']))
{
    $image = "images/profile/".$data['photo'];
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Rakan Akademik</title>

<style>

body{
    margin:0;
    font-family:Arial,sans-serif;
    background:#f5f5f5;
}

.container{
    width:1100px;
    margin:auto;
    padding-top:30px;
}

.back-btn{
    text-decoration:none;
    font-size:30px;
    color:black;
}

.title{
    text-align:center;
    color:#2748A5;
    font-size:50px;
    font-weight:bold;
    margin-bottom:30px;
}

.content{
    display:flex;
    gap:25px;
    align-items:flex-start;
}

.photo-section{
    width:180px;
    text-align:center;
}

.photo-section img{
    width:140px;
    height:140px;
    border-radius:50%;
    object-fit:cover;
}

.left-box,
.right-box{
    background:#DCECF8;
    padding:20px;
    border-radius:8px;
}

.left-box{
    width:450px;
}

.right-box{
    width:400px;
}

.section-title{
    font-weight:bold;
    margin-top:20px;
}

p{
    line-height:1.6;
}

</style>

</head>

<body>

<div class="container">

<a href="rakan_page.php" class="back-btn">
←
</a>

<div class="title">
Rakan Akademik
</div>

<div class="content">

<div class="photo-section">

<img src="<?php echo $image; ?>">

</div>

<div class="left-box">

<p>
<strong>Name :</strong>
<?php echo $data['name']; ?>
</p>

<p>
<strong>Programme :</strong>
<?php echo $data['programme']; ?>
</p>

<p>
<strong>Institution :</strong>
<?php echo $data['institution']; ?>
</p>

<p>
<strong>Current Status :</strong>
<?php echo $data['current_status']; ?>
</p>

<div class="section-title">
Academic Background
</div>

<p>
<?php echo nl2br($data['academic_background']); ?>
</p>

<div class="section-title">
Academic Strengths
</div>

<p>
<?php echo nl2br($data['academic_strengths']); ?>
</p>

</div>

<div class="right-box">

<p>
<strong>CGPA :</strong>
<?php echo $data['cgpa']; ?>
</p>

<div class="section-title">
Availability
</div>

<p>
<?php echo $data['availability']; ?>
</p>

<div class="section-title">
Contact
</div>

<p>
Email :
<?php echo $data['email']; ?>
</p>

<p>
Phone :
<?php echo $data['contact_number']; ?>
</p>

</div>

</div>

</div>

</body>
</html>