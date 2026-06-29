<?php
session_start();
include("db_connect.php");

if(!isset($_SESSION['matric']))
{
    header("Location:login.php");
    exit();
}

if(!isset($_GET['id']))
{
    header("Location:student_rakan.php");
    exit();
}

$matricNoTutor = mysqli_real_escape_string($conn,$_GET['id']);

$sql = mysqli_query($conn,"
SELECT *
FROM tutor
WHERE matricNoTutor='$matricNoTutor'
");

if(mysqli_num_rows($sql)==0)
{
    echo "
    <script>

    alert('Tutor not found.');

    window.location='student_rakan.php';

    </script>
    ";
    exit();
}

$data = mysqli_fetch_assoc($sql);

?>
<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Rakan Akademik</title>

<style>

body{
    margin:0;
    padding:0;
    font-family:Arial;
    background:url('images/edubackground.jpg');
    background-size:cover;
}

.container{

    width:1000px;

    margin:40px auto;

    background:white;

    padding:30px;

    border-radius:10px;

    box-shadow:0 0 15px rgba(0,0,0,.2);
}

.title{

    text-align:center;

    color:#2748A5;

    font-size:34px;

    font-weight:bold;

    margin-bottom:30px;
}

.content{

    display:flex;

    gap:25px;
}

.left,
.right{

    flex:1;

    background:#f4f7ff;

    padding:20px;

    border-radius:10px;
}

.section{

    margin-bottom:18px;
}

.section-title{

    color:#2748A5;

    font-weight:bold;

    margin-bottom:5px;
}

</style>

</head>

<body>

<div class="container">

<div class="title">

Rakan Akademik

</div>

<div class="content">

<div class="left">

<div class="section">

<div class="section-title">

Name

</div>

<?php echo htmlspecialchars($data['name']); ?>

</div>

<div class="section">

<div class="section-title">

Programme

</div>

<?php echo htmlspecialchars($data['programme']); ?>

</div>

<div class="section">

<div class="section-title">

Institution

</div>

<?php echo htmlspecialchars($data['institution']); ?>

</div>

<div class="section">

<div class="section-title">

Current Status

</div>

<?php echo htmlspecialchars($data['currentStatus']); ?>

</div>

<div class="section">

<div class="section-title">

Academic Background

</div>

<?php echo nl2br(htmlspecialchars($data['academicBackground'])); ?>

</div>

<div class="section">

<div class="section-title">

Academic Strengths

</div>

<?php echo nl2br(htmlspecialchars($data['academicStrengths'])); ?>

</div>

</div>

<div class="right">

<div class="section">

<div class="section-title">

CGPA

</div>

<?php echo htmlspecialchars($data['cgpa']); ?>

</div>

<div class="section">

<div class="section-title">

Expertise

</div>

<?php echo htmlspecialchars($data['expertise']); ?>

</div>

<div class="section">

<div class="section-title">

Availability

</div>

<?php echo nl2br(htmlspecialchars($data['availability'])); ?>

</div>

<div class="section">

<div class="section-title">

Contact Number

</div>

<?php echo htmlspecialchars($data['contactNumber']); ?>

</div>

<div class="section">

<div class="section-title">

Email

</div>

<?php echo htmlspecialchars($data['email']); ?>

</div>
</div>

</div>

<div style="text-align:center;margin-top:30px;">

<a
href="rakan_page.php"
style="
background:#2748A5;
color:white;
padding:12px 30px;
text-decoration:none;
border-radius:6px;">

Back

</a>

</div>

</div>

</body>

</html>