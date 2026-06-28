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

        .learning{
            background:white;
            flex:1;
            padding:25px;
            text-align:center;
            border:1px solid #ccc;
            box-shadow:0 2px 5px rgba(0,0,0,0.1);
        }

        .learning h1{
            font-size:32px;
        }

        .learning-wrapper{
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

        .module-container{
            width:100%;
            min-height:70vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .continue-section {
            display:flex;
            flex-direction:column;
            align-items:center;
        }

        .continue-section h2 {
            margin-bottom:15px;
        }

        .continue-card{
            background:white;
            border:1px solid #ccc;
            padding:30px;
            width:900px;
            max-width:90%;
            height:550px;
            text-align:center;
            box-shadow:0 2px 8px rgba(0,0,0,0.1);
            margin:0 auto; 
        }

        .continue-card img{
            width:100%;
            height:400px;
            object-fit:cover;
        }

        .btn-continue{
            display:inline-block;
            margin-top:15px;
            padding:10px 30px;
            background:#eee;
            color:black;
            text-decoration:none;
            border-radius:5px;
        }

        .btn-continue:hover{
            background:#1f3f98;
            color:white;
        }

        .recommended{
            width:60%;
            border-left:1px solid #ccc;
            padding:15px;
        }

        .subject-box{
            background:white;
            border:1px solid #dcdcdc;
            border-radius:10px;
            padding:15px;
            margin-top:20px;
            display:flex;
            align-items:center;
            height:110px;
        }

        .subject-box img{
            width:70px;
            height:70px;
            border-radius:50%;
            object-fit:cover;
        }

        .subject-info{
            flex:1;
            margin-left:15px;
        }

        .subject-info h3{
            margin-bottom:5px;
        }

        .subject-info p{
            color:#666;
        }

        .subject-box a{
            font-size:24px;
            color:#000;
            text-decoration:none;
        }

        .subject-box a:hover{
            color:#1f3f98;
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

<div class="learning-wrapper">
    <h2 class="back-btn" onclick="location.href='student_dashboard.php'">
        <i class="fas fa-arrow-left"></i>
    </h2>

    <section class="learning">
        <h1>LEARNING MODULE</h1>
    </section>
</div>

<div class="module-container">

    <div class="continue-section">
        <h2>Continue Learning</h2>

        <div class="continue-card">
            <img src="images/continuelearning.jpg" alt="Continue Learning">
            <a href="subjectsStudent.php" class="btn-continue">
                Continue
            </a>
        </div>
    </div>

</div>
</body>
</html>