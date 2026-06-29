<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit();
}

$matric = $_SESSION['matric'];

$sqlUser = mysqli_query($conn,"
SELECT *
FROM user
WHERE matricNoStudent='$matric'
");

if(mysqli_num_rows($sqlUser)==0){
    die("User not found.");
}

$user = mysqli_fetch_assoc($sqlUser);

$name   = $user['name'];
$email  = $user['email'];
$phone  = $user['mobile_phone'];
$role   = trim($user['role']);
$status = $user['status'];

$roles = array_map('trim', explode(",", $role));
$isTutor = in_array("Tutor", $roles);

$dashboard = $isTutor
    ? "choose_role.php"
    : "student_dashboard.php";

$programme      = "-";
$currentStatus  = "-";

if(!$isTutor){

    $sqlStudent = mysqli_query($conn,"
    SELECT *
    FROM student
    WHERE matricNoStudent='$matric'
    ");

    if(mysqli_num_rows($sqlStudent)>0){

        $student = mysqli_fetch_assoc($sqlStudent);

        $programme = $student['course'];
        $currentStatus = $status;
    }
}

else{

    $sqlTutor = mysqli_query($conn,"
    SELECT *
    FROM tutor
    WHERE matricNoTutor='$matric'
    ");

    if(mysqli_num_rows($sqlTutor)>0){

        $tutor = mysqli_fetch_assoc($sqlTutor);

        $programme = $tutor['programme'];
        $currentStatus = $tutor['currentStatus'];
    }
}

if(isset($_POST['btnUpdate'])){

    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));

    mysqli_query($conn,"
    UPDATE user
    SET
        name='$name',
        email='$email',
        mobile_phone='$phone'
    WHERE matricNoStudent='$matric'
    ");

    if($isTutor){

        mysqli_query($conn,"
        UPDATE tutor
        SET
            email='$email',
            contactNumber='$phone'
        WHERE matricNoTutor='$matric'
        ");
    }

    echo "
    <script>
        alert('Profile updated successfully.');
        window.location='profile.php';
    </script>
    ";

    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
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
    height:80px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:0 30px;
    box-shadow:0 3px 12px rgba(0,0,0,0.2);
}

.logo{
    display:flex;
    align-items:center;
    gap:18px;
}

.logo img{
    height:52px;
    width:auto;
}

.icons{
    display:flex;
    gap:15px;
}

.icon-btn{
    width:42px;
    height:42px;
    display:flex;
    justify-content:center;
    align-items:center;
    text-decoration:none;
    border-radius:50%;
    color:white;
    background:rgba(255,255,255,.12);
    transition:.25s;
}

.icon-btn:hover{
    background:white;
    color:#1f3f98;
}

.icon-btn i{
    font-size:18px;
}

form{
    width:55%;
    margin:40px auto;
    background:rgba(255,255,255,.95);
    padding:30px 35px;
    border-radius:18px;
    box-shadow:0 15px 35px rgba(0,0,0,.2);
}

h2{
    text-align:center;
    color:#1f3f98;
    margin-bottom:20px;
}

h3{
    margin-top:25px;
    color:#1f3f98;
    border-left:5px solid #1f3f98;
    padding-left:10px;
}

label{
    display:block;
    margin-top:15px;
    font-weight:bold;
}

input{
    width:100%;
    padding:12px;
    margin-top:6px;
    border:1px solid #ccc;
    border-radius:8px;
    font-size:14px;
}

input:focus{
    outline:none;
    border-color:#1f3f98;
    box-shadow:0 0 8px rgba(31,63,152,.3);
}

.button-group{
    display:flex;
    gap:15px;
    margin-top:35px;
}

.button-group button{
    flex:1;
    padding:12px;
    border:none;
    border-radius:10px;
    color:white;
    cursor:pointer;
    font-size:15px;
    font-weight:bold;
    transition:.2s;
}

.cancel-btn{
    background:#6c757d;
}

.cancel-btn:hover{
    background:#5a6268;
}

.save-btn{
    background:#1f3f98;
}

.save-btn:hover{
    background:#0f01ce;
}

@media(max-width:768px){

    form{
        width:90%;
        padding:20px;
    }

    .button-group{
        flex-direction:column;
    }

}
</style>

</head>

<body>

<header>

    <div class="logo">
        <img src="images/logoRakan.png" alt="Rakan Akademik">
        <img src="images/logoUtem.png" alt="UTeM">
        <img src="images/logoFtmk.png" alt="FTMK">
    </div>

    <div class="icons">

        <a href="<?php echo $dashboard; ?>" class="icon-btn" title="Back">
            <i class="fas fa-arrow-left"></i>
        </a>

        <a href="<?php echo $dashboard; ?>" class="icon-btn" title="Home">
            <i class="fas fa-home"></i>
        </a>

        <a href="profile.php" class="icon-btn" title="Profile">
            <i class="far fa-user"></i>
        </a>

    </div>

</header>

<form method="POST">

    <h2>Edit Profile</h2>

    <h3>Basic Information</h3>

    <label>Full Name</label>
    <input
        type="text"
        name="name"
        value="<?php echo htmlspecialchars($name); ?>"
        required>

    <label>Email Address</label>
    <input
        type="email"
        name="email"
        value="<?php echo htmlspecialchars($email); ?>"
        required>

    <label>Mobile Phone</label>
    <input
        type="tel"
        name="phone"
        pattern="[0-9]{10,11}"
        maxlength="11"
        value="<?php echo htmlspecialchars($phone); ?>"
        required>

    <h3>Academic Information</h3>

    <label>Matric Number</label>
    <input
        type="text"
        value="<?php echo htmlspecialchars($matric); ?>"
        readonly>

    <label>Programme</label>
    <input
        type="text"
        value="<?php echo htmlspecialchars($programme); ?>"
        readonly>

    <label>University</label>
    <input
        type="text"
        value="Universiti Teknikal Malaysia Melaka"
        readonly>

    <label>Current Status</label>
    <input
        type="text"
        value="<?php echo htmlspecialchars($currentStatus); ?>"
        readonly>

    <label>Role</label>
    <input
        type="text"
        value="<?php echo htmlspecialchars($role); ?>"
        readonly>

    <div class="button-group">

        <button
            type="button"
            class="cancel-btn"
            onclick="window.location='profile.php';">

            <i class="fas fa-times"></i>
            Back

        </button>

        <button
            type="submit"
            name="btnUpdate"
            class="save-btn">

            <i class="fas fa-save"></i>
            Save Changes

        </button>

    </div>

</form>

</body>
</html>