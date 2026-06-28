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

        .subject{
    background:white;
    flex:1;
    padding:25px;
    text-align:center;
    border:1px solid #ccc;
    box-shadow:0 2px 5px rgba(0,0,0,0.1);
}

        .subject h1{
            font-size:32px;
        }

        .subject-wrapper{
            width:90%;
            margin:20px auto 30px auto;
            display:flex;
            align-items:center;
            gap:20px;
        }

        .back-btn{
            cursor:pointer;
            font-size:28px;
        }

        .back-btn:hover{
            transform:scale(1.1);
            transition:0.2s;
        }

        .subject-card h2{
            height:60px; 
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .subject-link{
            text-decoration:none;
            color:black;
            width:40%;
        }

        .subjects-container{
            width:90%;
            margin:auto;
            display:flex;
            justify-content:space-around;
        }

        .subject-card{
            width:100%;
            background:white;
            border:1px solid #ccc;
            padding:25px;
            text-align:center;
        }

        .subject-card img{
            width:100%;
            height:250px;
            object-fit:cover;
        }   

        .subject-card:hover{
            transform:translateY(-5px);
            box-shadow:0 5px 15px rgba(0,0,0,0.2);
            cursor:pointer;
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
        <i class="fas fa-home" onclick="location.href='dashboard.php'"></i>
        <i class="far fa-user-circle" onclick="location.href='profile.php'"></i>
    </div>
</header>

<section class="subject-wrapper">
    <h2 class="back-btn" onclick="location.href='module.php'">
        <i class="fas fa-arrow-left"></i>
    </h2>

    <section class="subject">
        <h1>SUBJECTS</h1>
    </section>
</section>

<div class="subjects-container">

    <a href="subjProgramming.php" class="subject-link">
        <div class="subject-card">
            <h2>Programming</h2>
                <img src="images/programming.jpg" alt="Programming">
        </div>
    </a>

    <a href="subjDsa.php" class="subject-link">
        <div class="subject-card">
            <h2>Data Structure & Algorithms</h2>
                <img src="images/dsa.jpg" alt="DSA">
        </div>
    </a>
</div>

</body>
</html>
