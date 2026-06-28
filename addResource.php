<?php
include "db_connect.php";

$topic_id = isset($_GET['topic_id']) ? intval($_GET['topic_id']) : 0;
$subject  = isset($_GET['subject'])  ? $_GET['subject']          : '';

// Ambil nama topic
$topicRow = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT topic_name FROM topics WHERE topic_id = $topic_id"
));

$success = '';
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type  = mysqli_real_escape_string($conn, $_POST['type']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $link  = mysqli_real_escape_string($conn, $_POST['link']);

    if ($type && $title && $link) {
        $insert = mysqli_query($conn,
            "INSERT INTO resources (topic_id, type, title, link)
             VALUES ($topic_id, '$type', '$title', '$link')"
        );
        if ($insert) {
            $success = 'Add resource success!';
        } else {
            $error = 'Failed addin resource.';
        }
    } else {
        $error = 'Please fill in the resource.';
    }
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
            max-width: 600px;
            margin: 60px auto;
            background: white;
            border-radius: 12px;
            padding: 36px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }

        .form-wrapper h2 {
            margin-bottom: 6px;
            color: #1f3f98;
            font-size: 20px;
        }

        .topic-label {
            font-size: 13px;
            color: #666;
            margin-bottom: 24px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            margin-top: 16px;
            font-size: 14px;
        }

        input, select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #1f3f98;
        }

        .btn-submit {
            width: 100%;
            margin-top: 24px;
            padding: 11px;
            background: #1f3f98;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
        }

        .btn-submit:hover { background: #16317a; }

        .back-link {
            display: inline-block;
            margin-top: 16px;
            font-size: 13px;
            color: #1f3f98;
            text-decoration: none;
        }

        .back-link:hover { text-decoration: underline; }

        .alert-success {
            background: #e6f4ea; color: #2d6a4f;
            border: 1px solid #b7dfca;
            padding: 10px 14px; border-radius: 6px;
            margin-bottom: 16px; font-size: 14px;
        }

        .alert-error {
            background: #fdecea; color: #a61c00;
            border: 1px solid #f5c6c0;
            padding: 10px 14px; border-radius: 6px;
            margin-bottom: 16px; font-size: 14px;
        }
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
    <h2><i class="fas fa-plus-circle"></i> Add New Resource</h2>
    <p class="topic-label">
        Topic: <strong><?php echo htmlspecialchars($topicRow['topic_name'] ?? '-'); ?></strong>
    </p>

    <?php if ($success): ?>
        <div class="alert-success"><i class="fas fa-check-circle"></i> <?php echo $success; ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert-error"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Type</label>
        <select name="type" required>
            <option value="">-- Select Type --</option>
            <option value="video">Video</option>
            <option value="notes">Notes</option>
            <option value="tutorial">Tutorial</option>
        </select>

        <label>Title</label>
        <input type="text" name="title" placeholder="Example: Video, Notes, Tutorial" required>

        <label>Link</label>
        <input type="url" name="link" placeholder="Example: https://..." required>

        <button type="submit" class="btn-submit">
            <i class="fas fa-plus"></i> Add Resource
        </button>
    </form>

    <a class="back-link" href="subj<?php echo htmlspecialchars($subject); ?>.php">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

</body>
</html>
