<?php
session_start();
include("db_connect.php");

if(!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['userId'];

/* =========================
   GET USER DATA
========================= */
$sqlUser = mysqli_query($conn, "
    SELECT * FROM user 
    WHERE userId='$userId'
");

$user = mysqli_fetch_assoc($sqlUser);

if(!$user) {
    die("User not found");
}

$name  = $user['name'];
$email = $user['email'];
$phone = $user['phone'];
$role  = $user['role'];

/* =========================
   GET TUTOR DATA (IF ANY)
========================= */
$university = "";
$education  = "";
$cgpa       = "";
$about      = "";

if($role == "Tutor") {

    $sqlTutor = mysqli_query($conn, "
        SELECT * FROM rakan_profile 
        WHERE matricNoTutor='$userId'
    ");

    $tutor = mysqli_fetch_assoc($sqlTutor);

    if($tutor) {
        $university = $tutor['university'];
        $education  = $tutor['education'];
        $cgpa       = $tutor['cgpa'];
        $about      = $tutor['about'];
    }
}

/* =========================
   UPDATE PROCESS
========================= */
if(isset($_POST['btnUpdate'])) {

    $name  = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // update user table
    mysqli_query($conn, "
        UPDATE user SET
        name='$name',
        email='$email',
        phone='$phone'
        WHERE userId='$userId'
    ");

    // IF TUTOR → update extra table
    if($role == "Tutor") {

        $university = $_POST['university'];
        $education  = $_POST['education'];
        $cgpa       = $_POST['cgpa'];
        $about      = $_POST['about'];

        // check exists
        $check = mysqli_query($conn, "
            SELECT * FROM rakan_profile 
            WHERE matricNoTutor='$userId'
        ");

        if(mysqli_num_rows($check) > 0) {

            // update
            mysqli_query($conn, "
                UPDATE rakan_profile SET
                university='$university',
                education='$education',
                cgpa='$cgpa',
                about='$about'
                WHERE matricNoTutor='$userId'
            ");

        } else {

            // insert
            mysqli_query($conn, "
                INSERT INTO rakan_profile
                (matricNoTutor, university, education, cgpa, about)
                VALUES
                ('$userId','$university','$education','$cgpa','$about')
            ");
        }
    }

    echo "
    <script>
        alert('Profile Updated Successfully');
        window.location.href='profile.php';
    </script>
    ";
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
    font-family:Arial, sans-serif;
}

body{
    background-image: url('images/edubackground.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
}

/* HEADER (keep same style) */
header{
    background:#1f3f98;
    color:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 30px;
}

/* FORM WRAPPER */
form{
    width: 55%;
    margin: 40px auto;
    background: rgba(255,255,255,0.95);
    padding: 30px 35px;
    border-radius: 18px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    backdrop-filter: blur(6px);
}

/* SECTION TITLE */
h3{
    margin-top:25px;
    color:#1f3f98;
    border-left:5px solid #1f3f98;
    padding-left:10px;
}

/* LABEL */
label{
    display:block;
    margin-top:15px;
    font-weight:600;
    color:#333;
}

/* INPUT STYLE */
input, textarea{
    width:100%;
    padding:12px 14px;
    margin-top:6px;
    border:1px solid #d0d0d0;
    border-radius:10px;
    outline:none;
    transition:0.2s ease;
    font-size:14px;
}

/* FOCUS EFFECT */
input:focus, textarea:focus{
    border-color:#1f3f98;
    box-shadow:0 0 8px rgba(31,63,152,0.3);
}

/* TEXTAREA */
textarea{
    min-height:100px;
    resize:vertical;
}

/* BUTTON */
button{
    margin-top:25px;
    width:100%;
    padding:12px;
    background:#1f3f98;
    color:white;
    border:none;
    border-radius:10px;
    cursor:pointer;
    font-size:15px;
    font-weight:bold;
    transition:0.2s;
}

button:hover{
    background:#0f01ce;
    transform:scale(1.02);
}

/* RESPONSIVE */
@media(max-width:768px){
    form{
        width:90%;
        padding:20px;
    }
}
</style>

</head>

<body>

<header>
    <h2 style="color:white; padding:15px;">Edit Profile</h2>
</header>

<form method="POST">

    <label>Name</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">

    <label>Email</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">

    <label>Phone</label>
    <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>">

    <?php if($role == "Tutor") { ?>

        <h3 style="margin-top:20px;">Tutor Info</h3>

        <label>University</label>
        <input type="text" name="university" value="<?php echo htmlspecialchars($university); ?>">

        <label>Education</label>
        <input type="text" name="education" value="<?php echo htmlspecialchars($education); ?>">

        <label>CGPA</label>
        <input type="text" name="cgpa" value="<?php echo htmlspecialchars($cgpa); ?>">

        <label>About</label>
        <textarea name="about"><?php echo htmlspecialchars($about); ?></textarea>

    <?php } ?>

    <button type="submit" name="btnUpdate">
        Update Profile
    </button>

</form>

</body>
</html>
</html>