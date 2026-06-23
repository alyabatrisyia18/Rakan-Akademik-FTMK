<?php
session_start();
include 'db_connect.php';

$category = isset($_GET['category']) ? $_GET['category'] : '';

if ($category == '') {
    echo "<script>
        alert('Please choose a category first');
        window.location.href='category.php';
    </script>";
    exit();
}

$sql = "SELECT * FROM quiz
        WHERE category = ?
        ORDER BY quizID DESC";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("SQL Error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $category);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #e9eef5;
        }

        .topbar {
            background: #233f99;
            height: 110px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            gap: 25px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo img {
            height: 48px;
            width: auto;
            object-fit: contain;
        }

        .search-box {
            width: 40%;
            background: white;
            border-radius: 30px;
            padding: 0 18px;
            display: flex;
            align-items: center;
        }

        .search-box input {
            width: 100%;
            border: none;
            outline: none;
            background: transparent;
            font-size: 16px;
            padding: 14px 0;
        }

        .search-box i {
            font-size: 22px;
            color: #777;
        }

        .icons {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .icons i {
            font-size: 26px;
            cursor: pointer;
            color: white;
        }

        .icons i:hover {
            opacity: 0.8;
            transform: scale(1.1);
        }

        .container {
            padding: 35px;
        }

        .quiz-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }

        .quiz-card {
            width: 430px;
            background: white;
            border-radius: 18px;
            padding: 25px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        .quiz-card h3 {
            color: #233f99;
            font-size: 30px;
            margin-bottom: 16px;
            text-transform: uppercase;
        }

        .quiz-card p {
            font-size: 18px;
            margin-bottom: 12px;
            color: #000;
        }

        .start-btn {
            background: #233f99;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            cursor: pointer;
            margin-top: 12px;
            font-size: 16px;
        }

        .start-btn:hover {
            opacity: 0.9;
        }

        .empty {
            background: white;
            padding: 25px;
            border-radius: 15px;
            font-size: 18px;
        }
    </style>
</head>

<body>
<header class="topbar">
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
        <i class="fas fa-arrow-left" onclick="location.href='category.php'"></i>
        <i class="far fa-bookmark"></i>
        <i class="far fa-bell"></i>
        <i class="far fa-user-circle" onclick="location.href='profile.php'"></i>
    </div>
</header>

<div class="container">
    <?php if (mysqli_num_rows($result) > 0) { ?>
        <div class="quiz-grid">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="quiz-card">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>

                    <p>
                        <?php echo htmlspecialchars($row['description']); ?>
                    </p>

                    <p>
                        <b>Subject:</b>
                        <?php echo htmlspecialchars($row['category']); ?>
                    </p>

                    <p>
                        <b>Difficulty:</b>
                        <?php echo htmlspecialchars($row['difficulty']); ?>
                    </p>

                    <button 
                        class="start-btn"
                        onclick="location.href='start_quiz.php?quizID=<?php echo urlencode($row['quizID']); ?>'">Start Quiz
                    </button>
                </div>
            <?php } ?>
        </div>

    <?php } else { ?>
        <div class="empty">
            No quiz available
        </div>
    <?php } ?>
</div>

</body>
</html>