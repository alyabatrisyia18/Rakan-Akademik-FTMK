<?php
session_start();

if (!isset($_SESSION['userId'])) {

    header("Location: login.php");
    exit();
}

$userId = $_SESSION['userId'];
$role_clean = strtolower(trim($_SESSION['role']));

if (!in_array($role_clean, ['tutor','rakan'])) {
    header("Location: dashboard.php");
    exit();
}

include("db_connect.php");

$sqlCheck = mysqli_query($conn,
"SELECT * FROM rakan_profile
WHERE matricNoTutor='$userId'");

$data = mysqli_fetch_assoc($sqlCheck);

if(!$data)
{
    echo "
    <script>
    alert('Please complete your profile first.');
    window.location='rakan_form.php';
    </script>
    ";
    exit();
}

$image = "images/profile.jpg";

if(
    !empty($data['photo']) &&
    file_exists("imagess/".$data['photo'])
){
    $image = "imagess/".$data['photo'];
}
?>

<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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

<a href="dashboard.php" class="back-btn">
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
<?php echo htmlspecialchars($data['currentStatus']); ?>
</p>

<div class="section-title">
Academic Background
</div>

<p>
<?php echo nl2br(htmlspecialchars($data['academicBackground'])); ?>
</p>

<div class="section-title">
Academic Strengths
</div>

<p>
<?php echo nl2br(htmlspecialchars($data['academicStrengths'])); ?>
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
<?php echo htmlspecialchars($data['contactNumber']); ?>
</p>

</div>

</div>

<div class="edit-area">

<a href="rakan_form.php">

<button class="edit-btn">
Edit Profile
</button>

</a>

</div>

</div>

</body>
</html>