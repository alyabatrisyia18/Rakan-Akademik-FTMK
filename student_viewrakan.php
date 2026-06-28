<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['userId'])) {

    header("Location: login.php");
    exit();
}
$role = strtolower(trim($_SESSION['role']));
if ($role != "student") {
    header("Location: dashboard.php");
    exit();
}

$id = (int)$_GET['id'];

$sql = mysqli_query($conn,"
SELECT *
FROM rakan_profile
WHERE profileID=$id
");

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

$image = "uploads/profile.jpg";

if (
    !empty($data['photo']) &&
    file_exists("uploads/".$data['photo'])
){
    $image = "uploads/".$data['photo'];
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Rakan Akademik</title>

<style>

body{
    margin:0;
    font-family: Arial, sans-serif;
    background-image: url('images/edubackground.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
}

.container{
    width: 1100px;
    margin: 30px auto;
    padding: 30px;
    background: rgba(255,255,255,0.85);
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    backdrop-filter: blur(5px);
}

.back-btn{
    text-decoration: none;
    font-size: 26px;
    color: #1f3c88;
    font-weight: bold;
}

.title{
    text-align: center;
    color: #1f3c88;
    font-size: 42px;
    font-weight: bold;
    margin-bottom: 30px;
}

.content{
    display: flex;
    gap: 25px;
    align-items: flex-start;
}

/* responsive flex improvement */
.left-box,
.right-box{
    flex: 1;
    background: rgba(220,236,248,0.7);
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.photo-section{
    width: 180px;
    text-align: center;
}

.photo-section img{
    width: 140px;
    height: 140px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #3fa9f5;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.section-title{
    font-weight: bold;
    margin-top: 20px;
    color: #1f3c88;
}

p{
    line-height: 1.6;
    font-size: 15px;
}

.edit-area{
    text-align: center;
    margin-top: 40px;
}

.edit-btn{
    background: #3fa9f5;
    color: white;
    border: none;
    padding: 12px 35px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    transition: 0.3s;
}

.edit-btn:hover{
    background: #1b8ce3;
    transform: translateY(-2px);
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
<?php echo $data['currentStatus']; ?>
</p>

<div class="section-title">
Academic Background
</div>

<p>
<?php echo nl2br($data['academicBackground']); ?>
</p>

<div class="section-title">
Academic Strengths
</div>

<p>
<?php echo nl2br($data['academicStrengths']); ?>
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
<?php echo $data['contactNumber']; ?>
</p>

</div>

</div>

</div>

</body>
</html>