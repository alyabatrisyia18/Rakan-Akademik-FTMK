<?php
include "db_connect.php";

$selectedSubject = "";

if(isset($_GET['subject'])){
    $selectedSubject = $_GET['subject'];
}

if(isset($_POST['submit'])){

    $subject = $_POST['subject'];
    $chapter = $_POST['chapter'];
    $topic = $_POST['topic'];
    $video = $_POST['video'];
    $tutorial = $_POST['tutorial'];
    $notes = $_POST['notes'];

    mysqli_query($conn,
    "INSERT INTO chapters (subject, chapter_name)
    VALUES ('$subject','$chapter')"
    );

    $chapter_id = mysqli_insert_id($conn);

    mysqli_query($conn,
    "INSERT INTO topics (chapter_id, topic_name)
    VALUES ('$chapter_id','$topic')"
    );

    $topic_id = mysqli_insert_id($conn); 

    mysqli_query($conn,
    "INSERT INTO resources (topic_id, type, title, link)
    VALUES
    ('$topic_id','video','Video','$video'),
    ('$topic_id','notes','Notes','$notes'),
    ('$topic_id','tutorial','Tutorial','$tutorial')"
    );

    if($subject == "Programming"){
        header("Location: subjProgramming.php");
    }
    else if($subject == "Dsa"){
        header("Location: subjDsa.php");
    }
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
            background: white;
        }

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

        .container{
            display:flex;
            min-height:calc(100vh - 90px);
            justify-content:center;
            align-items:center;
        }

        .content{
            flex:1;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .form-card{
            width:650px;
            border:1px solid #ddd;
            border-radius:15px;
            padding:40px;
            background:white;
        }

        .form-card h2{
            margin-bottom:25px;
        }

        input{
            width:100%;
            padding:15px;
            border:1px solid #ddd;
            border-radius:8px;
            margin-bottom:20px;
            font-size:16px;
        }

        button{
            width:100%;
            background:#1f3f98;
            color:white;
            border:none;
            padding:15px;
            border-radius:8px;
            cursor:pointer;
            font-size:16px;
        }

        button:hover{
            background:#16317a;
        }

        .back-btn{

            margin-top:20px;
            display:inline-block;
            text-decoration:none;
            color:#1f3f98;
        }

        label{
            display:block;
            margin-bottom:8px;
            font-weight:bold;
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

<div class="container">

    <main class="content">
        <div class="form-card">
            <h2><i class="fas fa-book"></i>Add New Chapter</h2>

            <form method="POST">

                <label>Subject</label>
                    <input type="text" name="subject" value="<?php echo $selectedSubject; ?>" readonly>

                <label>Chapter</label>
                <input type="text" name="chapter" placeholder="Example: Chapter (number)" required>

                <label>Topic</label>
                <input type="text" name="topic" placeholder="Example: Loop" required>

                <label>Video</label>
                <input type="text" name="video" placeholder="Example: https://youtube.com/...">

                <label>Tutorials</label>
                <input type="text" name="tutorial" placeholder="Example: https://www.w3schools.com/...">

                <label>Notes</label>
                <input type="text" name="notes" placeholder="Example: website link">

                <button name="submit"><i class="fas fa-plus"></i>Add Chapter</button>

            </form>

            <a class="back-btn" href="<?php 
                echo ($selectedSubject == 'Programming') 
                ? 'subjProgramming.php' 
                : 'subjDsa.php'; 
            ?>">
                <i class="fas fa-arrow-left"></i>
                    Back
            </a>

        </div>
    </main>
</div>
    
</body>
</html>



