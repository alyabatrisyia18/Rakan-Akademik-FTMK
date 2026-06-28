<?php
include "db_connect.php";

$chapter_id = isset($_GET['chapter_id']) ? intval($_GET['chapter_id']) : 0;
$subject    = isset($_GET['subject'])    ? $_GET['subject']            : '';

$chapterRow = null;
$result = mysqli_query($conn, "SELECT chapter_name FROM chapters WHERE chapter_id = $chapter_id");
if ($result) {
    $chapterRow = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topic_name = mysqli_real_escape_string($conn, $_POST['topic']);

    $insert = mysqli_query($conn,
        "INSERT INTO topics (chapter_id, topic_name)
         VALUES ($chapter_id, '$topic_name')"
    );

    if (!$insert) {
        die("Insert failed: " . mysqli_error($conn));
    }

    header("Location: subj$subject.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:Arial,sans-serif; }
        body { background:#f0f4fc; }
        header {
            background:#1f3f98; color:white;
            display:flex; justify-content:space-between;
            align-items:center; padding:15px 30px;
        }
        .logo img { height:60px; width:auto; }
        .icons i { font-size:24px; margin-left:20px; cursor:pointer; }
        .form-wrapper {
            max-width:600px; margin:60px auto;
            background:white; border-radius:12px;
            padding:36px; box-shadow:0 2px 12px rgba(0,0,0,0.08);
        }
        .form-wrapper h2 { margin-bottom:6px; color:#1f3f98; font-size:20px; }
        .chapter-label { font-size:13px; color:#666; margin-bottom:24px; }
        label { display:block; font-weight:600; margin-bottom:6px; margin-top:16px; font-size:14px; }
        input {
            width:100%; padding:10px 14px;
            border:1px solid #ccc; border-radius:6px; font-size:14px;
        }
        input:focus { outline:none; border-color:#1f3f98; }
        .btn-submit {
            width:100%; margin-top:24px; padding:11px;
            background:#1f3f98; color:white; border:none;
            border-radius:6px; font-size:15px; cursor:pointer;
        }
        .btn-submit:hover { background:#16317a; }
        .back-link {
            display:inline-block; margin-top:16px;
            font-size:13px; color:#1f3f98; text-decoration:none;
        }
        .back-link:hover { text-decoration:underline; }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="images/logoRakan.png" alt="Rakan Akademik Logo">
        <img src="images/logoUtem.png"  alt="UTeM Logo">
        <img src="images/logoFtmk.png"  alt="FTMK Logo">
    </div>
    <div class="icons">
        <i class="fas fa-home" onclick="location.href='dashboard.php'"></i>
        <i class="far fa-user-circle" onclick="location.href='profile.php'"></i>
    </div>
</header>

<div class="form-wrapper">
    <h2><i class="fas fa-plus-circle"></i> Add New Topic</h2>
    <p class="chapter-label">
        Chapter: <strong><?php echo htmlspecialchars($chapterRow['chapter_name'] ?? '-'); ?></strong>
    </p>

    <form method="POST">
        <label>Topic Name</label>
        <input type="text" name="topic" placeholder="Example: Data Types" required>

        <button type="submit" class="btn-submit">
            <i class="fas fa-plus"></i> Add Topic
        </button>
    </form>

    <a class="back-link" href="subj<?php echo htmlspecialchars($subject); ?>.php">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

</body>
</html>