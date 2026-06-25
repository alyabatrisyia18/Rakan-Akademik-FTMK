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

        .learning{
            background:white;
            width:90%;
            margin:20px auto 30px auto;
            padding:25px;
            text-align:center;
            border:1px solid #ccc;
            box-shadow:0 2px 5px rgba(0,0,0,0.1);
        }

        .learning h1{
            font-size:32px;
        }

        .module-container{
            width:90%;
            margin:auto;
            display:flex;
            justify-content:center;
            gap:40px;
            align-items:flex-start;
        }

        .continue-section,
        .progress-section{
            flex:1;
        }

        .continue-section h2,
        .progress-section h2{
            margin-bottom:15px;
        }

        .continue-card{
            background:white;
            border:1px solid #ccc;
            padding:20px;
            width:700px;
            min-height:400px;
            text-align:center;
            box-shadow:0 2px 8px rgba(0,0,0,0.1);
        }

        .continue-card img{
            width:100%;
            height:280px;
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

        .progress-card{
            background:white;
            border:1px solid #ccc;
            width:700px;
            height:400px; 
            padding:20px;
            box-shadow:0 2px 8px rgba(0,0,0,0.1);
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

<section class="learning">
    <h1>LEARNING MODULE</h1>
</section>

<div class="module-container">

    <div class="continue-section">
        <h2>Continue Learning</h2>

        <div class="continue-card">
            <img src="images/continuelearning.jpg" alt="Continue Learning">
            <a href="subjects.php" class="btn-continue">
                Continue
            </a>
        </div>
    </div>

    <div class="progress-section">
        <h2>Learning Progress</h2>

        <div class="progress-card">
            <h4>Recommended Subjects</h4>

             <div class="subject-box">
                <img src="images/programming.jpg">

                <div class="subject-info">
                    <h3>Programming</h3>
                    <p>Array</p>
                </div>

                <a href="subject_progress.php">
                    <i class="fas fa-chevron-right"></i>
                </a>

            </div>

            <div class="subject-box">
                <img src="images/dsa.jpg">

                <div class="subject-info">
                    <h3>DSA</h3>
                    <p>Hashing</p>
                </div>

                <a href="subject_progress.php">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>

    </div>

</div>
</body>
</html>