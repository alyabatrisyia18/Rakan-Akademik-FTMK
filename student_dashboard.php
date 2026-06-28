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

        .logo img{
            height:60px;   /* ubah ikut saiz yang nak */
            width:auto;
        }

        .welcome{
            background:#284db6;
            color:white;
            text-align:center;
            padding:20px;
            position:relative;
        }
        
        .welcome h1{
            font-size:32px;
        }

        .apply-btn{ 
            position:absolute;
            right:30px;
            bottom:15px;
            background:whitw;
            color:black;
            padding:10px 20px;
            border:none;
            border-radius:30px;
            font-size:15px;
            cursor:pointer;
            transition:0.3s;
        }

        .back-btn{
            cursor:pointer;
            font-size:28px;
        }

        .menu-container{
            width:85%;
            margin:30px auto;
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:25px;
        }

        .card{
            background:white;
            border:2px solid #ddd;
            border-radius:20px;
            text-align:center;
            padding:30px;
            cursor:pointer;
            transition:0.3s;
        }

        .card:hover{
            transform:translateY(-5px);
            box-shadow:0 5px 15px rgba(0,0,0,0.2);
        }

        .card img{
            width:180px;
            height:180px;
            object-fit:contain;
        }

        .card h2{
            margin-top:15px;
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
        <i class="far fa-user-circle" onclick="location.href='profile.php'"></i>
    </div>
</header>

<section class="welcome">
    <h1>WELCOME TO STUDENT</h1>

    <button class="apply-btn"
        onclick="window.location.href='register_rakan.php'"><i class="fas fa-user-plus"></i> Apply Tutor </button>
</section>

<div class="back-container">
    <button class="back-btn" onclick="window.location.href='choose_role.php'"><i class="fas fa-arrow-left"></i></button>
</div>

<section class="menu-container">

    <div class="card" onclick="openPage('module')">
        <img src="images/module.jpg" alt="">
        <h2>Learning Module</h2>
    </div>

    <div class="card" onclick="openPage('quiz')">
        <img src="images/quiz.jpg" alt="">
        <h2>Quiz</h2>
    </div>

    <div class="card" onclick="openPage('timetable')">
        <img src="images/timetable.jpg" alt="">
        <h2>Timetable</h2>
    </div>

    <div class="card" onclick="openPage('mentor')">
        <img src="images/tutor.jpg" alt="">
        <h2>Rakan Akademik</h2>
    </div>

</section>

<script>
function openPage(page){

    switch(page){
        case "learning module":
            window.location.href="";
            break;

        case "quiz":
            window.location.href="category.php";
            break;

        case "timetable":
            window.location.href="booking.php";
            break;

        case "mentor":
            window.location.href="rakan_page.php";
            break;

        default:
            alert("Page not found");
    }
}
</script>
//
</body>
</html>