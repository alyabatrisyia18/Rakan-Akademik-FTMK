<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<title>Learning Module</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background-image:url('images/edubackground.jpg');
    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;
    background-attachment:fixed;
}

/* HEADER */

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

/* BACK BUTTON */

.back-btn{
    margin:20px 5%;
    font-size:36px;
    cursor:pointer;
    color:black;
}

.back-btn i:hover{
    color:#1f3f98;
}

/* TITLE */

.page-title{
    width:90%;
    margin:auto;
    background:white;
    border:1px solid #ddd;
    text-align:center;
    padding:20px;
    font-size:32px;
    font-weight:bold;
    border-radius:10px;
}

/* CONTENT */

.container{
    width:90%;
    margin:35px auto;
    display:flex;
    gap:30px;
    flex-wrap:wrap;
}

.section{
    flex:1;
    min-width:400px;
}

.section h2{
    margin-bottom:15px;
    color:black;
    font-size:28px;
    font-weight:bold;
}

/* CARD */

.card{
    background:white;
    border-radius:15px;
    padding:15px;
    cursor:pointer;
    transition:0.3s;
    box-shadow:0 4px 12px rgba(0,0,0,0.15);
}

.card:hover{
    transform:translateY(-5px);
    box-shadow:0 8px 20px rgba(0,0,0,0.25);
}

.card img{
    width:100%;
    height:350px;
    object-fit:contain;
    display:block;
}

/* RESPONSIVE */

@media(max-width:900px){

    .container{
        flex-direction:column;
    }

    .section{
        min-width:100%;
    }

    .search-box{
        display:none;
    }
}

</style>
</head>

<body>

<header>

    <div class="logo">
        <img src="images/logoRakan.png" alt="">
        <img src="images/logoUtem.png" alt="">
        <img src="images/logoFtmk.png" alt="">
    </div>

    <div class="search-box">
        <input type="text" placeholder="Search">
        <i class="fas fa-search"></i>
    </div>

    <div class="icons">
        <i class="far fa-bookmark"></i>
        <i class="far fa-bell"></i>
        <i class="far fa-user-circle"
           onclick="location.href='profile.php'"></i>
    </div>

</header>

<div class="back-btn">
    <i class="fas fa-arrow-left"
       onclick="location.href='dashboard.php'"></i>
</div>

<div class="page-title">
    Learning Module
</div>

<div class="container">

    <!-- Continue Learning -->

    <div class="section">

        <h2>Continue Learning</h2>

        <div class="card"
             onclick="location.href='programming.php'">

            <img src="images/continuelearning.jpg"
                 alt="Continue Learning">

        </div>

    </div>

    <!-- Learning Progress -->

    <div class="section">

        <h2>Learning Progress</h2>

        <div class="card"
             onclick="location.href='learningprogress.php'">

            <img src="images/learningprogress.jpg"
                 alt="Learning Progress">

        </div>

    </div>

</div>

</body>
</html>