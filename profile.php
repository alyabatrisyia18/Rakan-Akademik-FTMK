<?php 
session_start();
include("db_connect.php");

// SECURITY CHECK
if(!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['userId'];

/* =========================
   GET USER BASIC INFO
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
   NORMALIZE ROLE (IMPORTANT)
========================= */
$role_clean = strtolower(trim($role));

/* =========================
   DASHBOARD ROUTING (FIXED)
========================= */
function getDashboard($role_clean) {

    switch($role_clean) {
        case "student":
            return "student_dashboard.php";

        case "rakan":
        case "tutor":
        case "admin":
        default:
            return "dashboard.php";
    }
}

$dashboard = getDashboard($role_clean);

/* =========================
   DEFAULT PROFILE VALUES
========================= */
$university = "-";
$education  = "-";
$cgpa       = "-";
$about      = "No profile information yet";

/* =========================
   EXTRA DATA (ONLY IF EXISTS)
========================= */
if($role_clean == "tutor" || $role_clean == "rakan") {

    $sqlTutor = mysqli_query($conn, "
        SELECT * FROM rakan_profile 
        WHERE matricNoTutor='$userId'
    ");

    if($sqlTutor && mysqli_num_rows($sqlTutor) > 0) {
        $tutor = mysqli_fetch_assoc($sqlTutor);

        $university = $tutor['university'];
        $education  = $tutor['education'];
        $cgpa       = $tutor['cgpa'];
        $about      = $tutor['about'];
    }
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

/* ===== HEADER ===== */
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

.icons{
    display:flex;
    align-items:center;
    gap:18px;
}

/* ICON BUTTON */
.icon-btn{
    color:white;
    font-size:20px;
    width:40px;
    height:40px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    transition:0.2s;
    background:rgba(255,255,255,0.1);
    text-decoration:none;
}

.icon-btn:hover{
    transform: scale(1.1);
    background:rgba(255,255,255,0.25);
}

/* HERO SPACING (kalau nak kosong bawah header) */
.bottom-profile-wrapper{
    padding: 30px;
    display:flex;
    justify-content:center;
}

/* CONTAINER */
.profile-main-container{
    width:100%;
    max-width:1300px;
}

/* PROFILE CARD */
.profile-card{
    background:white;
    border-radius:28px;
    padding:28px 32px;
    display:flex;
    align-items:center;
    gap:28px;
    flex-wrap:wrap;
    box-shadow:0 20px 35px -12px rgba(0,0,0,0.15);
    border:1px solid rgba(39,72,165,0.2);
    margin-bottom:32px;
}

.profile-pic{
    width:130px;
    height:130px;
    border-radius:50%;
    object-fit:cover;
    border:5px solid #2748A5;
    background:#f9f9ff;
    box-shadow:0 8px 18px rgba(0,0,0,0.1);
}

.profile-info h2{
    font-size:1.9rem;
    font-weight:700;
    color:#111827;
}

.profile-info p{
    color:#4b5563;
    font-size:1.05rem;
    margin-top:6px;
    display:flex;
    align-items:center;
    gap:6px;
}

.profile-info p i{
    color:#2748A5;
}

/* GRID */
.details-grid{
    display:grid;
    grid-template-columns:repeat(2, 1fr);
    gap:28px;
}

/* BOX */
.info-box{
    background:white;
    padding:24px 26px;
    border-radius:24px;
    box-shadow:0 10px 22px -8px rgba(0,0,0,0.08);
    border:1px solid #eef2ff;
    transition:0.2s;
}

.info-box:hover{
    transform:translateY(-3px);
    box-shadow:0 20px 28px -12px rgba(0,0,0,0.12);
}

.info-box h3{
    color:#1e3a8a;
    font-size:1.5rem;
    margin-bottom:18px;
    font-weight:600;
    display:flex;
    align-items:center;
    gap:12px;
    border-left:5px solid #3b82f6;
    padding-left:16px;
}

.info-box p{
    color:#1f2937;
    line-height:1.65;
    font-size:1rem;
}

/* FOOTER TEXT */
.footer-text{
    margin-top:32px;
    text-align:center;
    font-size:0.75rem;
    color:#4b5563;
    border-top:1px solid #e2e8f0;
    padding-top:20px;
}

/* LOGOUT */
.btn{
    border:none;
    cursor:pointer;
}

.logout-container{
    display:flex;
    justify-content:center;
    margin-top:15px;
    margin-bottom:20px;
}

.logout-btn{
    padding:10px 20px;
    background:#b91c1c;
    color:white;
    border:none;
    border-radius:8px;
    cursor:pointer;
    transition:0.2s;
}

.logout-btn:hover{
    background:#991b1b;
}

/* RESPONSIVE */
@media (max-width:850px){
    .details-grid{
        grid-template-columns:1fr;
    }

    .profile-card{
        flex-direction:column;
        text-align:center;
    }
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
    
<div class="icons">

    <!-- BACK -->
    <a href="<?php echo $dashboard; ?>" class="icon-btn" title="Back">
        <i class="fas fa-arrow-left"></i>
    </a>

    <!-- HOME -->
    <a href="<?php echo $dashboard; ?>" class="icon-btn" title="Home">
        <i class="fas fa-home"></i>
    </a>

    <!-- PROFILE -->
    <a href="profile.php" class="icon-btn" title="Profile">
        <i class="fa-regular fa-user"></i>
    </a>

</div>
</header>

<div class="bottom-profile-wrapper">
    <div class="profile-main-container">
        
        <div class="profile-card">
            <img src="images/profile.jpg" class="profile-pic" alt="Profile picture" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?background=2748A5&color=fff&name=Rogayah+Binti+Isnin&size=120&rounded=true&bold=true';">
            <div class="profile-info">
                    <h2><?php echo htmlspecialchars($name); ?></h2>
                    <p><i class="fas fa-university"></i>
                    <?php echo htmlspecialchars($university); ?></p>
                    <p><i class="fas fa-user-tag"></i>
                    Role: <?php echo htmlspecialchars($role); ?></p>
            </div>
        </div>

        <div class="details-grid">

            <div class="info-box">
                    <h3><i class="fas fa-address-card"></i> Contact</h3>
                    <p><i class="fas fa-envelope"></i>
                    Email: <?php echo htmlspecialchars($email); ?></p>
                    <p style="margin-top: 12px;">
                        <i class="fas fa-phone-alt"></i>
                        Phone: <?php echo htmlspecialchars($phone); ?></p>
            </div>

            <div class="info-box">
                    <h3><i class="fas fa-book-open"></i> Education</h3>
                    <p><i class="fas fa-graduation-cap"></i>
                    <?php echo htmlspecialchars($education); ?></p>
                    
                    <p style="margin-top: 14px;">
                        <i class="fas fa-star"></i>
                        CGPA: <?php echo htmlspecialchars($cgpa); ?></p>
            </div>

            <div class="info-box">
                    <h3><i class="fas fa-user-astronaut"></i> About Me</h3>
                    <p><?php echo htmlspecialchars($about); ?></p>
            </div>

            <div class="info-box">
                <h3><i class="fas fa-info-circle"></i> Status</h3>
                <p>Account Role: <strong><?php echo htmlspecialchars($role); ?></strong></p>
                
                <p style="margin-top: 12px;">
                    System Status: Active
                </p>
            </div>
        </div>

        <div style="margin-top: 32px; text-align: center; font-size: 0.75rem; color: #4b5563; border-top: 1px solid #e2e8f0; padding-top: 20px;">
            <i class="fas fa-id-card"></i> RAKAN AKADEMIK • Student Profile 
        </div>
        
        <div class="logout-container">
            <button class="btn logout-btn" onclick="location.href='login.php'">
                <i class="fa fa-sign-out-alt"></i> Logout
            </button>
        </div>
    </div>
</div>

</body>
</html>