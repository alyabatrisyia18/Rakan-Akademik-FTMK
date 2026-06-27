<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['userId'];

$sqlUser = mysqli_query($conn, "
    SELECT *
    FROM user
    WHERE userId='$userId'
");

if (!$sqlUser || mysqli_num_rows($sqlUser) == 0) {
    die("User not found.");
}

$user = mysqli_fetch_assoc($sqlUser);

$name  = $user['name'];
$email = $user['email'];
$phone = $user['mobile_phone'];
$role  = $user['role'];

$role_clean = strtolower(trim($role));

if ($role_clean != "student" && $role_clean != "tutor") {
    header("Location: login.php");
    exit();
}
$dashboard = ($role_clean == "student")
    ? "student_dashboard.php"
    : "dashboard.php";

$photo = "images/profile.jpg";

$programme          = "";
$institution        = "";
$currentStatus      = "";
$academicBackground = "";
$academicStrengths  = "";
$cgpa               = "";
$availability       = "";

if ($role_clean == "tutor") {

    $sqlTutor = mysqli_query($conn,"
        SELECT *
        FROM rakan_profile
        WHERE matricNoTutor='$userId'
    ");

    if ($sqlTutor && mysqli_num_rows($sqlTutor) > 0) {

        $tutor = mysqli_fetch_assoc($sqlTutor);

        $programme          = $tutor['programme'];
        $institution        = $tutor['institution'];
        $currentStatus      = $tutor['currentStatus'];
        $academicBackground = $tutor['academicBackground'];
        $academicStrengths  = $tutor['academicStrengths'];
        $cgpa              = $tutor['cgpa'];
        $availability      = $tutor['availability'];

        if (
            !empty($tutor['photo']) &&
            file_exists("uploads/".$tutor['photo'])
        ) {
            $photo = "uploads/".$tutor['photo'];
        }
    }
}

if (isset($_POST['btnUpdate'])) {

    $name  = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));

    mysqli_query($conn,"
        UPDATE user SET
            name='$name',
            email='$email',
            mobile_phone='$phone'
        WHERE userId='$userId'
    ");

    if ($role_clean == "tutor") {

        $programme          = mysqli_real_escape_string($conn, trim($_POST['programme']));
        $institution        = mysqli_real_escape_string($conn, trim($_POST['institution']));
        $currentStatus      = mysqli_real_escape_string($conn, trim($_POST['currentStatus']));
        $academicBackground = mysqli_real_escape_string($conn, trim($_POST['academicBackground']));
        $academicStrengths  = mysqli_real_escape_string($conn, trim($_POST['academicStrengths']));
        $cgpa              = mysqli_real_escape_string($conn, trim($_POST['cgpa']));
        $availability      = mysqli_real_escape_string($conn, trim($_POST['availability']));

        $photoName = "";
        
        if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){
            if($_FILES['photo']['size'] > 2 * 1024 * 1024){
                die("Image size must not exceed 2MB.");
                }
            
                $extension = strtolower(
                    pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION)
                    );
                    
                    $allowed = ['jpg','jpeg','png','webp'];
                    
            if(!in_array($extension, $allowed)){
                die("Only JPG, JPEG, PNG and WEBP are allowed.");
                }
                
            $photoName = time()."_".basename($_FILES['photo']['name']);

            if(!move_uploaded_file( $_FILES['photo']['tmp_name'], "uploads/".$photoName
            )){
                die("Failed to upload photo.");
            }
        }

        if (empty($photoName)) {

            $photoQuery = mysqli_query($conn,"
                SELECT photo
                FROM rakan_profile
                WHERE matricNoTutor='$userId'
            ");

            if ($photoQuery && mysqli_num_rows($photoQuery) > 0) {

                $old = mysqli_fetch_assoc($photoQuery);
                $photoName = $old['photo'];

            }
        }

        $check = mysqli_query($conn,"
            SELECT profileID
            FROM rakan_profile
            WHERE matricNoTutor='$userId'
        ");

        if (mysqli_num_rows($check) > 0) {

            mysqli_query($conn,"
                UPDATE rakan_profile SET

                photo='$photoName',
                name='$name',
                programme='$programme',
                institution='$institution',
                currentStatus='$currentStatus',
                academicBackground='$academicBackground',
                academicStrengths='$academicStrengths',
                cgpa='$cgpa',
                availability='$availability',
                contactNumber='$phone',
                email='$email'

                WHERE matricNoTutor='$userId'
            ");

        } else {

            mysqli_query($conn,"
                INSERT INTO rakan_profile(

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
                    '$currentStatus',
                    '$academicBackground',
                    '$academicStrengths',
                    '$cgpa',
                    '$availability',
                    '$phone',
                    '$email'

                )
            ");
        }
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
    font-family:Arial, sans-serif;
}

body{
    background-image: url('images/edubackground.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
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
    object-fit:contain;
}

.icons{
    display:flex;
    align-items:center;
    gap:15px;
}

.icon-btn{
    width:42px;
    height:42px;
    display:flex;
    justify-content:center;
    align-items:center;

    color:#fff;
    background:rgba(255,255,255,0.12);

    border-radius:50%;
    text-decoration:none;

    transition:.25s;
}

.icon-btn i{
    font-size:18px;
}

.icon-btn:hover{
    background:white;
    color:#1f3f98;
    transform:translateY(-2px);
}

form{
    width: 55%;
    margin: 40px auto;
    background: rgba(255,255,255,0.95);
    padding: 30px 35px;
    border-radius: 18px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    backdrop-filter: blur(6px);
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
    font-weight:600;
    color:#333;
}

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

input:focus, textarea:focus{
    border-color:#1f3f98;
    box-shadow:0 0 8px rgba(31,63,152,0.3);
}

textarea{
    min-height:100px;
    resize:vertical;
}

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
select{
    width:100%;
    padding:12px 14px;
    margin-top:6px;
    border:1px solid #d0d0d0;
    border-radius:10px;
    outline:none;
    font-size:14px;
}

select:focus{
    border-color:#1f3f98;
    box-shadow:0 0 8px rgba(31,63,152,0.3);
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

<form method="POST" enctype="multipart/form-data">

    <h2 style="text-align:center;color:#1f3f98;">
        Edit Profile
    </h2>

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

<?php if($role_clean=="tutor"){ ?>

    <h3>Tutor Information</h3>

    <label>Current Profile Picture</label>

    <div style="text-align:center;margin:15px 0;">
        <img
            src="<?php echo $photo; ?>"
            style="width:140px;
                   height:140px;
                   border-radius:50%;
                   object-fit:cover;
                   border:4px solid #1f3f98;">
    </div>

    <label>Upload New Picture</label>
    <small style="display:block; color:#777; margin:5px 0 10px;">
    Accepted formats: JPG, JPEG, PNG, WEBP (Maximum 2MB)
    </small>
    <input
        type="file"
        name="photo"
        accept=".jpg,.jpeg,.png">

    <label>Programme</label>

    <input
        type="text"
        name="programme"
        value="<?php echo htmlspecialchars($programme); ?>">

    <label>Institution</label>

    <input
        type="text"
        name="institution"
        value="<?php echo htmlspecialchars($institution); ?>">

    <label>Current Status</label>

    <input
        type="text"
        name="currentStatus"
        value="<?php echo htmlspecialchars($currentStatus); ?>">

    <label>Academic Background</label>

    <textarea
        name="academicBackground"><?php echo htmlspecialchars($academicBackground); ?></textarea>

    <label>Academic Strengths</label>

    <textarea
        name="academicStrengths"><?php echo htmlspecialchars($academicStrengths); ?></textarea>

    <label>CGPA</label>

    <input
        type="number"
        name="cgpa"
        step="0.01"
        min="0"
        max="4.00"
        required
        value="<?php echo htmlspecialchars($cgpa); ?>">

    <label>Availability</label>

    <select name="availability">

        <option value="">-- Select Availability --</option>

        <option value="Available"
        <?php if($availability=="Available") echo "selected"; ?>>
        Available
        </option>

        <option value="Busy"
        <?php if($availability=="Busy") echo "selected"; ?>>
        Busy
        </option>

        <option value="Unavailable"
        <?php if($availability=="Unavailable") echo "selected"; ?>>
        Unavailable
        </option>

    </select>

<?php } ?>

    <div style="display:flex;gap:15px;margin-top:35px;">

        <button
            type="button"
            onclick="window.location='profile.php';"
            style="background:#6c757d;">
            <i class="fas fa-times"></i>
            Cancel
        </button>

        <button
            type="submit"
            name="btnUpdate">

            <i class="fas fa-save"></i>
            Save Changes

        </button>

    </div>

</form>

</body>
</html>