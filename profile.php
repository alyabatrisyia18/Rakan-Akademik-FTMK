<?php
$name = "Rogayah Binti Isnin";
$email = "gayah@gmail.com";
$phone = "010-9665902";
$university = "Universiti Teknikal Malaysia Melaka, UTeM";
$education = "Diploma in Computer Science";
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

        /* Layout ats */

        header{
            background:#1f3f98;
            color:white;
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:15px 30px;
        }

        .search-box{
            width:40%;
            position:relative;
        }

        .search-box input{
            width:100%;
            padding:10px 40px 10px 15px;
            border:none;
            border-radius:30px;
        }

        .search-box i{
            position:absolute;
            right:15px;
            top:50%;
            transform:translateY(-50%);
            color:gray;
        }

        .icons i{
            font-size:24px;
            margin-left:20px;
            cursor:pointer;
        }

        .icons i:hover{
            transform: scale(1.1);
            transition: 0.2s;
        } 

        .logo img{
            height:60px;   
            width:auto;
        }
    
         /* Layout ats */

         .nav-left h3 {
            font-weight: 600;
            font-size: 1.5rem;
            letter-spacing: 0.5px;
            background: linear-gradient(135deg, #ffffff, #e0e7ff);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            text-shadow: none;
        }

        .btn-group {
            display: flex;
            gap: 14px;
        }

        .btn {
            padding: 8px 20px;
            border: none;
            cursor: pointer;
            border-radius: 40px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.12);
            color: white;
        }

        .btn i {
            font-size: 1rem;
        }

        .home-btn {
            background: #0f01ce;
        }

        .home-btn:hover {
            background: #0a0092;
            transform: scale(1.02);
        }

        .logout-btn {
            background: #b91c1c;
        }

        .logout-btn:hover {
            background: #991b1b;
            transform: scale(1.02);
        }

        .logo-section{
            display:flex;
            flex-direction:column;
            align-items:center;
            gap:15px;
        }

        .logout-container{
            display:flex;
            justify-content:center;
            margin-top:15px;
             margin-bottom:20px;
        }

        .hero-banner {
            background: linear-gradient(105deg, #102a5e 0%, #2c5282 100%);
            height: 260px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .hero-banner::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 200" opacity="0.1"><path fill="white" d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"/></svg>');
            background-repeat: repeat-x;
            background-position: bottom;
            background-size: 800px;
            pointer-events: none;
        }

        .bottom-profile-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-end;   
            margin-top: auto;         
            padding: 20px 30px 50px 30px;  
        }

        .profile-main-container {
            width: 100%;
            max-width: 1300px;
            margin: 0 auto;
        }

        /* CARD UTAMA (profile ringkas + gambar) */
        .profile-card {
            background: white;
            border-radius: 28px;
            padding: 28px 32px;
            display: flex;
            align-items: center;
            gap: 28px;
            flex-wrap: wrap;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(39, 72, 165, 0.2);
            transition: transform 0.2s;
            margin-bottom: 32px;
        }

        .profile-pic {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #2748A5;
            background: #f9f9ff;
            box-shadow: 0 8px 18px rgba(0,0,0,0.1);
        }

        .profile-info h2 {
            font-size: 1.9rem;
            font-weight: 700;
            color: #111827;
            letter-spacing: -0.3px;
        }

        .profile-info p {
            color: #4b5563;
            font-size: 1.05rem;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .profile-info p i {
            color: #2748A5;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 28px;
            margin-top: 8px;
        }

        .info-box {
            background: white;
            padding: 24px 26px;
            border-radius: 24px;
            box-shadow: 0 10px 22px -8px rgba(0, 0, 0, 0.08);
            transition: all 0.2s;
            border: 1px solid #eef2ff;
        }

        .info-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 28px -12px rgba(0, 0, 0, 0.12);
            border-color: #cbdff2;
        }

        .info-box h3 {
            color: #1e3a8a;
            font-size: 1.5rem;
            margin-bottom: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
            border-left: 5px solid #3b82f6;
            padding-left: 16px;
        }

        .info-box h3 i {
            font-size: 1.4rem;
            color: #2c5f9a;
        }

        .info-box p, .info-box ul {
            color: #1f2937;
            line-height: 1.65;
            font-size: 1rem;
        }

        .skill-list {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 8px;
        }

        .skill-badge {
            background: #eef2ff;
            padding: 6px 16px;
            border-radius: 40px;
            font-weight: 500;
            color: #1e3a8a;
            font-size: 0.9rem;
            letter-spacing: 0.3px;
        }

        .about-text {
            background: #fafcff;
            padding: 12px 0 4px 0;
            border-radius: 12px;
        }

        @media (max-width: 850px) {
            .details-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .profile-card {
                flex-direction: column;
                text-align: center;
                padding: 24px 20px;
            }

            .profile-info h2 {
                font-size: 1.6rem;
            }

            .bottom-profile-wrapper {
                padding: 10px 20px 40px 20px;
            }
        }

        @media (max-width: 500px) {
            header {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
            }
            .btn-group {
                justify-content: center;
            }
            .info-box {
                padding: 20px;
            }
        }

        .btn:active {
            transform: scale(0.97);
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

    <div class="search-box">
        <input type="text" placeholder="Search">
        <i class="fas fa-search"></i>
    </div>

    <div class="icons">
        <i class="far fa-bookmark"></i>
        <i class="far fa-bell"></i>
        <i class="far fa-user-circle" onclick="location.href='profile.php'"></i>
    </div>
</header>

<div class="hero-banner">
     <button class="btn home-btn" onclick="location.href='dashboard.php'">
            <i class="fa fa-home"></i> Home
        </button>
</div>

<div class="bottom-profile-wrapper">
    <div class="profile-main-container">
        
        <div class="profile-card">
            <img src="images/profile.jpg" class="profile-pic" alt="Profile picture" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?background=2748A5&color=fff&name=Rogayah+Binti+Isnin&size=120&rounded=true&bold=true';">
            <div class="profile-info">
                <h2><?php echo htmlspecialchars($name); ?></h2>
                <p><i class="fas fa-university"></i> <?php echo htmlspecialchars($university); ?></p>
                <p><i class="fas fa-map-marker-alt"></i> Melaka, Malaysia</p>
            </div>
        </div>

        <div class="details-grid">

            <div class="info-box">
                <h3><i class="fas fa-address-card"></i> Contact</h3>
                <p><i class="fas fa-envelope" style="width: 24px; color:#2c3e66;"></i> <strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p style="margin-top: 12px;"><i class="fas fa-phone-alt" style="width: 24px; color:#2c3e66;"></i> <strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
                <p style="margin-top: 12px;"><i class="fab fa-whatsapp" style="width: 24px; color:#25D366;"></i> <strong>WhatsApp:</strong> +60<?php echo substr(htmlspecialchars($phone), 3); ?></p>
            </div>

            <div class="info-box">
                <h3><i class="fas fa-book-open"></i> Education</h3>
                <p><i class="fas fa-graduation-cap"></i> <?php echo htmlspecialchars($education); ?></p>
                <p style="margin-top: 14px;"><i class="fas fa-clock"></i> Status: Active Semester (Year 2)</p>
                <p><i class="fas fa-chalkboard-user"></i> CGPA: 3.89 / 4.00</p>
            </div>

            <div class="info-box">
                <h3><i class="fas fa-code"></i> Technical Skills</h3>
                <div class="skill-list">
                    <span class="skill-badge"><i class="fab fa-cuttlefish"></i> C++</span>
                    <span class="skill-badge"><i class="fab fa-html5"></i> HTML</span>
                    <span class="skill-badge"><i class="fab fa-js"></i> JavaScript</span>
                    <span class="skill-badge"><i class="fas fa-database"></i> MySQL</span>
                </div>
                <p style="margin-top: 18px;"><strong>Tools:</strong> VS Code, Figma (basic)</p>
            </div>

            <div class="info-box">
                <h3><i class="fas fa-user-astronaut"></i> About Me</h3>
                <div class="about-text">
                    <p>Active student at <strong>Universiti Teknikal Malaysia Melaka (UTeM)</strong> in <strong>Computer Science</strong>.</p>
                </div>
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