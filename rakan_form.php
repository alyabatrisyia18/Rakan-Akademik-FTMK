<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

include("db_connect.php");

$userId = $_SESSION['userId'];

if (strtolower($_SESSION['role']) != "tutor") {
    header("Location: dashboard.php");
    exit();
}

$sqlCheck = mysqli_query($conn,"
SELECT *
FROM rakan_profile
WHERE matricNoTutor='$userId'
");

$data = [];

if($sqlCheck && mysqli_num_rows($sqlCheck)>0)
{
    $data=mysqli_fetch_assoc($sqlCheck);
}

if(isset($_POST['btnSubmit']))
{
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $programme = mysqli_real_escape_string($conn,$_POST['programme']);
    $institution = mysqli_real_escape_string($conn,$_POST['institution']);
    $current_status = mysqli_real_escape_string($conn,$_POST['current_status']);

    $academic_background =
    mysqli_real_escape_string($conn,$_POST['academic_background']);

    $academic_strengths =
    mysqli_real_escape_string($conn,$_POST['academic_strengths']);

    $cgpa = $_POST['cgpa'];

    $availability =
    mysqli_real_escape_string($conn,$_POST['availability']);

    $contact_number =
    mysqli_real_escape_string($conn,$_POST['contact_number']);

    $email =
    mysqli_real_escape_string($conn,$_POST['email']);

    $photoName = "";

    if(isset($_FILES['photo']) && $_FILES['photo']['error']==0){
        if($_FILES['photo']['size'] > 2 * 1024 * 1024){
        die("Image size must not exceed 2MB.");
        }
        $extension = strtolower(
        pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION)
        );
        $allowed = ['jpg','jpeg','png','webp'];

        if(!in_array($extension,$allowed)){
        die("Only JPG, JPEG, PNG and WEBP are allowed.");
        }
        
        $photoName=time()."_".basename($_FILES['photo']['name']);
        
        if(!move_uploaded_file(
        $_FILES['photo']['tmp_name'],
        "uploads/".$photoName
        ))
        {
        die("Failed to upload image.");
        }
    }

    $check =
    mysqli_query($conn,
    "SELECT * FROM rakan_profile
    WHERE matricNoTutor='$userId'");

    if(mysqli_num_rows($check) > 0)
    {
        if($photoName != "")
        {
            $sql = "UPDATE rakan_profile SET

            photo='$photoName',
            name='$name',
            programme='$programme',
            institution='$institution',
            currentStatus='$current_status',
            academicBackground='$academic_background',
            academicStrengths='$academic_strengths',
            cgpa='$cgpa',
            availability='$availability',
            contactNumber='$contact_number',
            email='$email'

            WHERE matricNoTutor='$userId'";
        }
        else
        {
            $sql = "UPDATE rakan_profile SET

            name='$name',
            programme='$programme',
            institution='$institution',
            currentStatus='$current_status',
            academicBackground='$academic_background',
            academicStrengths='$academic_strengths',
            contactNumber='$contact_number',
            cgpa='$cgpa',
            availability='$availability',
            email='$email'

            WHERE matricNoTutor='$userId'";
        }

        mysqli_query($conn,$sql);
    }
    else
    {
        $sql = "INSERT INTO rakan_profile(

        matricNoTutor,
        photo,
        name,
        programme,
        institution,
        currentStatus,
        academicBackground,
        academicStrengths,
        cgpa,
        availability,
        contactNumber,
        email

        )

        VALUES(

        '$userId',
        '$photoName',
        '$name',
        '$programme',
        '$institution',
        '$current_status',
        '$academic_background',
        '$academic_strengths',
        '$cgpa',
        '$availability',
        '$contact_number',
        '$email'

        )";

        mysqli_query($conn,$sql);
    }

    echo "
    <script>
    alert('Profile Saved Successfully');
    window.location='rakan_view.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Rakan Akademik Form</title>

<style>
body{
    font-family: Arial;
    margin: 0;
    padding: 0;
    background-image: url('images/edubackground.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
}

.container{
    width: 1000px;
    margin: 30px auto;
    background: rgba(255, 255, 255, 0.85);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    backdrop-filter: blur(5px);
}

.title{
    text-align: center;
    color: #1f3c88;
    margin-bottom: 25px;
    font-size: 28px;
    font-weight: bold;
}

.form-box{
    display:flex;
    gap:30px;
}

.left,
.right{
    flex: 1;
    background: rgba(220, 236, 248, 0.7);
    padding: 25px;
    border-radius: 12px;
}

label{
    display:block;
    margin-top:10px;
    font-weight:bold;
}

input[type=text],
input[type=email],
input[type=number],
textarea{
    width: 100%;
    padding: 10px;
    margin-top: 6px;
    border: 1px solid #ccc;
    border-radius: 8px;
    outline: none;
}

input:focus,
textarea:focus{
    border-color: #3fa9f5;
    box-shadow: 0 0 5px rgba(63,169,245,0.5);
}

.profile-photo{
    text-align:center;
    margin-bottom:20px;
}

.profile-photo img{
    width:140px;
    height:140px;
    border-radius:50%;
    object-fit:cover;
}

button{
    padding: 10px 25px;
    border: none;
    border-radius: 8px;
    background: #3fa9f5;
    color: white;
    cursor: pointer;
    margin: 5px;
}

.button-area{
    text-align: center;
}

button:hover{
    background: #1b8ce3;
}
.navbar-custom{
    background:#1f3f98;
    height:70px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 25px;
}

.logo-section{
    display:flex;
    align-items:center;
    gap:12px;
}

.logo-section img{
    height:45px;
}

.icon-section{
    display:flex;
    align-items:center;
    gap:20px;
}

/* HOME BUTTON (adapted to small navbar version) */
.home-btn{
    background:#1f3f98;
    color:white;
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:8px 15px;
    border-radius:0 0 8px 8px;
    font-size:13px;
    cursor:pointer;
    transition:0.3s;
    margin-left:25px;
}

.home-btn:hover{
    background:#162f73;
}

.home-btn i{
    font-size:20px;
}

/* PROFILE ICON */
.profile-link{
    text-decoration:none;
}

.profile-icon{
    width:40px;
    height:40px;
    border-radius:50%;
    background:#e8dcff;
    display:flex;
    justify-content:center;
    align-items:center;
    cursor:pointer;
    transition:0.3s;
}

.profile-icon:hover{
    transform:scale(1.1);
}

.profile-icon i{
    color:#5b3c8c;
}

</style>

</head>

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

<div class="container">

<h1 class="title">
Welcome To Rakan Akademik Form
</h1>

<form method="POST"
enctype="multipart/form-data">

<div class="profile-photo">

<?php

$image = "uploads/profile.jpg";

if(!empty($data['photo']) &&
file_exists("uploads/".$data['photo']))
{
$image="uploads/".$data['photo'];
}

?>

<img src="<?php echo $image; ?>">

<br><br>

<input type="file" name="photo">

</div>

<div class="form-box">

<div class="left">

<label>Name</label>

<input type="text"
name="name"
required
value="<?php echo $data['name'] ?? ''; ?>">

<label>Programme</label>

<input type="text"
name="programme"
required
value="<?php echo $data['programme'] ?? ''; ?>">

<label>Institution</label>

<input type="text"
name="institution"
required
value="<?php echo $data['institution'] ?? ''; ?>">

<label>Current Status</label>

<input type="text"
name="current_status"
required
value="<?php echo $data['currentStatus'] ?? ''; ?>">

<label>Academic Background</label>

<textarea
name="academic_background"
rows="5"
required><?php echo $data['academicBackground'] ?? ''; ?></textarea>

<label>Academic Strengths</label>

<textarea
name="academic_strengths"
rows="5"
required><?php echo $data['academicStrengths'] ?? ''; ?></textarea>

</div>

<div class="right">

<label>CGPA</label>

<input type="number"
step="0.01"
min="0"
max="4.00"
name="cgpa"
required
value="<?php echo $data['cgpa'] ?? ''; ?>">

<label>Availability</label>

<input type="text"
name="availability"
required
value="<?php echo $data['availability'] ?? ''; ?>">

<label>Contact Number</label>

<input type="text"
maxlength="11"
name="contact_number"
required
value="<?php echo $data['contactNumber'] ?? ''; ?>">

<label>Email</label>

<input type="email"
name="email"
required
value="<?php echo $data['email'] ?? ''; ?>">

</div>

</div>

<div class="button-area">

<button type="reset">
Reset
</button>

<button
type="submit"
name="btnSubmit">
Submit
</button>

</div>

</form>

</div>

</body>
</html>