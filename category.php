<!DOCTYPE html>
<html>
<head>
    <title>Quiz Categories</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
    body{
        background:url('images/edubackground.jpg');
    }
    </style>

</head>
<body>

<header class="topbar">
    <div class="logo">
        <img src="images/logoRakan.png" alt="Rakan Akademik Logo">
        <img src="images/logoUtem.png" alt="UTeM Logo">
        <img src="images/logoFtmk.png" alt="FTMK Logo">
        <img class="quiz-logo" src="images/quiz.jpg" alt="Quiz Logo">
    </div>

    <div class="icons">
        <i class="fas fa-home" onclick="location.href='student_dashboard.php'" title="Dashboard"></i>
        <i class="far fa-user-circle" onclick="location.href='profile.php'"></i>
    </div>
</header>

<div class="menu-bar">
    <a href="progress.php" class="active-menu">Progress Tracker</a>
</div>

<div class="main-content">

    <h2>Choose one from categories below</h2>

    <div class="category-container">
        <a href="quiz_list.php?category=Programming" class="category-card"> 
            Programming
        </a>
        
        <a href="quiz_list.php?category=Data%20Structure%20%26%20Algorithm" class="category-card">
            Data Structure<br>& Algorithm
        </a>
    </div>

</div>
</script>

</body>
</html>