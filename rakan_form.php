<?php
session_start();

/*
if(!isset($_SESSION['matric']))
{
    header("Location: login.php");
    exit();
}

if($_SESSION['role'] != "Tutor")
{
    header("Location: dashboard.php");
    exit();
}
*/
include("db_connect.php");

$matric = $_SESSION['matric'];

$sqlCheck = mysqli_query($conn,
"SELECT * FROM rakan_profile
WHERE matricNoTutor='$matric'");

$data = mysqli_fetch_assoc($sqlCheck);

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

    if(!empty($_FILES['photo']['name']))
    {
        $photoName =
        time()."_".$_FILES['photo']['name'];

        move_uploaded_file(
            $_FILES['photo']['tmp_name'],
            "images/profile/".$photoName
        );
    }

    $check =
    mysqli_query($conn,
    "SELECT * FROM rakan_profile
    WHERE matricNoTutor='$matric'");

    if(mysqli_num_rows($check) > 0)
    {
        if($photoName != "")
        {
            $sql = "UPDATE rakan_profile SET

            photo='$photoName',
            name='$name',
            programme='$programme',
            institution='$institution',
            current_status='$current_status',
            academic_background='$academic_background',
            academic_strengths='$academic_strengths',
            cgpa='$cgpa',
            availability='$availability',
            contact_number='$contact_number',
            email='$email'

            WHERE matricNoTutor='$matric'";
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

            WHERE matricNoTutor='$matric'";
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

        '$matric',
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
    font-family:Arial;
    background:#f4f6f9;
}

.container{
    width:1000px;
    margin:auto;
    margin-top:30px;
}

.title{
    text-align:center;
    color:#2748A5;
    margin-bottom:30px;
}

.form-box{
    display:flex;
    gap:30px;
}

.left,
.right{
    flex:1;
    background:#dcecf8;
    padding:25px;
    border-radius:10px;
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
    width:100%;
    padding:8px;
    margin-top:5px;
}

textarea{
    resize:none;
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

.button-area{
    text-align:center;
    margin-top:30px;
}

button{
    padding:10px 25px;
    border:none;
    background:#3fa9f5;
    color:white;
    cursor:pointer;
    margin:5px;
}

button:hover{
    background:#1b8ce3;
}

</style>

</head>

<body>

<div class="container">

<h1 class="title">
Welcome To Rakan Akademik Form
</h1>

<form method="POST"
enctype="multipart/form-data">

<div class="profile-photo">

<?php

$image = "images/puterisarah.jpg";

if(!empty($data['photo']))
{
    $image =
    "images/profile/".$data['photo'];
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
value="<?php echo $data['current_status'] ?? ''; ?>">

<label>Academic Background</label>

<textarea
name="academic_background"
rows="5"
required><?php echo $data['academic_background'] ?? ''; ?></textarea>

<label>Academic Strengths</label>

<textarea
name="academic_strengths"
rows="5"
required><?php echo $data['academic_strengths'] ?? ''; ?></textarea>

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
value="<?php echo $data['contact_number'] ?? ''; ?>">

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