<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['matric'])) {
    echo "<script>
        alert('Please login first');
        window.location.href='login.php';
    </script>";
    exit();
}

if (isset($_POST['publish'])) {

    $quizID = "Q" . time();
    $matricNoTutor = $_SESSION['matric'];

    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $difficulty = $_POST['difficulty'];

    $time_limit = !empty($_POST['time_limit']) ? $_POST['time_limit'] : 30; //user tak isi time limit auto akan set 90 minit masa utk jwab
    $attempts = !empty($_POST['attempts']) ? $_POST['attempts'] : 1; //auto akan set 1 kali attempt

    $visibility = "Public";
    $show_results = "Yes";

    $cover = "";

    //utk check sama ada tutor upload gambar cover plus tkde error time upload
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] == 0) {

        $folder = "uploads/";

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $filename = time() . "_" . basename($_FILES['cover']['name']); //elak supaya nama fail sme
        $targetFile = $folder . $filename;

        move_uploaded_file($_FILES['cover']['tmp_name'], $targetFile); //pindh gmba kpd folder upload

        $cover = $targetFile; //simpn gmbr path dekat database
    }

    $sqlQuiz = "
        INSERT INTO quiz
        (quizID, matricNoTutor, title, description, category, difficulty, cover, time_limit, attempts)
        VALUES
        ('$quizID', '$matricNoTutor', '$title', '$description', '$category', '$difficulty', '$cover', '$time_limit', '$attempts')
    ";

    mysqli_query($conn, $sqlQuiz);

    $questions = $_POST['question'];
    $optionA = $_POST['optionA'];
    $optionB = $_POST['optionB'];
    $optionC = $_POST['optionC'];
    $optionD = $_POST['optionD'];
    $correct = $_POST['correct_answer'];

    for ($i = 0; $i < count($questions); $i++) {

        if (trim($questions[$i]) != "") {

            $sqlQuestion = "
                INSERT INTO quiz_question
                (quizID, question, optionA, optionB, optionC, optionD, correct_answer)
                VALUES
                (
                    '$quizID',
                    '{$questions[$i]}',
                    '{$optionA[$i]}',
                    '{$optionB[$i]}',
                    '{$optionC[$i]}',
                    '{$optionD[$i]}',
                    '{$correct[$i]}'
                )
            ";

            mysqli_query($conn, $sqlQuestion);
        }
    }

    echo "<script>
        alert('Quiz published successfully!');
        window.location.href='quiz.php';
    </script>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create New Quiz</title>
    <link rel="stylesheet" href="style2.css">
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
            cursor: pointer;
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

        .main-container {
            display: flex;
            gap: 30px;
            padding: 25px;
        }

        .form-area {
            flex: 2;
            background: white;
            padding: 25px;
            border-radius: 15px;
        }

        .preview-area {
            flex: 1;
            background: white;
            padding: 25px;
            border-radius: 15px;
            height: fit-content;
        }

        .tabs {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

        .tab {
            background: #dcdcdc;
            padding: 12px 25px;
            border-radius: 25px;
            cursor: pointer;
        }

        .tab.active {
            background: #233f99;
            color: white;
        }

        .page {
            display: none;
        }

        .page.show {
            display: block;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        textarea {
            height: 100px;
            resize: none;
        }

        button {
            background: #233f99;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            cursor: pointer;
            margin-top: 20px;
            margin-right: 10px;
        }

        .question-box {
            background: #f1f3f8;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .delete-btn {
            background: crimson;
        }

        .preview-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .preview-card h2 {
            color: #233f99;
            margin-bottom: 15px;
        }

        .preview-card p {
            margin-bottom: 10px;
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

    <div class="icons">
        <i class="fas fa-home" onclick="location.href='dashboard.php'"></i>
        <i class="far fa-user-circle" onclick="location.href='profile.php'"></i>
    </div>
</header>

<div class="menu-bar">
    <a href="progress.php" class="active-menu">Progress Tracker</a>
</div>

<div class="main-container">
    <div class="form-area">

        <div class="tabs">
            <div class="tab active" onclick="showPage('details', this)">1 Quiz Details</div>
            <div class="tab" onclick="showPage('questions', this)">2 Questions</div>
            <div class="tab" onclick="showPage('settings', this)">3 Quiz Settings</div>
        </div>

        <form method="POST" enctype="multipart/form-data">

            <div id="details" class="page show">
                <label>Quiz Title</label>
                <input type="text" name="title" id="title" required onkeyup="updatePreview()">

                <label>Description</label>
                <textarea name="description" id="description" onkeyup="updatePreview()"></textarea>

                <label>Subject/Category</label>
                <select name="category" id="category" onchange="updatePreview()">
                    <option value="Programming">Programming</option>
                    <option value="Data Structure & Algorithm">Data Structure & Algorithm</option>
                </select>

                <label>Difficulty Level</label>
                <select name="difficulty" id="difficulty" onchange="updatePreview()" required>
                    <option value="">Choose Difficulty</option>
                    <option value="Easy">Easy</option>
                    <option value="Medium">Medium</option>
                    <option value="Hard">Hard</option>
                </select>

                <label>Quiz Cover Page</label>
                <input type="file"
                       name="cover"
                       id="cover"
                       accept="image/png,image/jpeg,image/jpg">

                <button type="button" onclick="showPageById('questions')">Next</button>
            </div>

            <div id="questions" class="page">
                <div id="questionContainer">

                    <div class="question-box">
                        <label>Question 1</label>
                        <input type="text" name="question[]" placeholder="Enter your question">

                        <label>Option A</label>
                        <input type="text" name="optionA[]" placeholder="Option A">

                        <label>Option B</label>
                        <input type="text" name="optionB[]" placeholder="Option B">

                        <label>Option C</label>
                        <input type="text" name="optionC[]" placeholder="Option C">

                        <label>Option D</label>
                        <input type="text" name="optionD[]" placeholder="Option D">

                        <label>Correct Answer</label>
                        <select name="correct_answer[]">
                            <option value="">Choose Answer</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>

                        <button type="button" class="delete-btn" onclick="deleteQuestion(this)">Delete</button>
                    </div>

                </div>

                <button type="button" onclick="addQuestion()">+ Add Question</button>
                <button type="button" onclick="showPageById('settings')">Next</button>
            </div>

            <div id="settings" class="page">
                <h2>Quiz Settings</h2>

                <label>Time Limit (minutes)</label>
                <input type="number" name="time_limit" placeholder="Enter time limit">

                <label>Attempts Allowed</label>
                <input type="number" name="attempts" placeholder="Enter attempts allowed">

                <button type="submit" name="publish">Publish</button>
            </div>

        </form>

    </div>

    <div class="preview-area">
        <div class="preview-card">

            <img id="previewImage" src="images/default_cover.jpg" alt="Quiz Cover Preview">

            <h2 id="previewTitle">Quiz Title Preview</h2>

            <p id="previewDescription">
                Description preview will appear here
            </p>

            <p>
                <b>Subject:</b>
                <div id="previewCategory">Programming</div>
            </p>

            <p>
                <b>Difficulty:</b>
                <div id="previewDifficulty">-</div>
            </p>

        </div>
    </div>

</div>

<script>
function showPage(pageId, element) {
    document.querySelectorAll('.page').forEach(page => {
        page.classList.remove('show');
    });

    document.getElementById(pageId).classList.add('show');

    document.querySelectorAll('.tab').forEach(tab => {
        tab.classList.remove('active');
    });

    element.classList.add('active');
}

function showPageById(pageId) {
    document.querySelectorAll('.page').forEach(page => {
        page.classList.remove('show');
    });

    document.getElementById(pageId).classList.add('show');

    document.querySelectorAll('.tab').forEach(tab => {
        tab.classList.remove('active');
    });

    if (pageId === 'details') {
        document.querySelectorAll('.tab')[0].classList.add('active');
    } else if (pageId === 'questions') {
        document.querySelectorAll('.tab')[1].classList.add('active');
    } else if (pageId === 'settings') {
        document.querySelectorAll('.tab')[2].classList.add('active');
    }
}

function addQuestion() {
    let container = document.getElementById('questionContainer');
    let questionCount = container.children.length + 1;

    let div = document.createElement('div');
    div.className = 'question-box';

    div.innerHTML = `
        <label>Question ${questionCount}</label>
        <input type="text" name="question[]" placeholder="Enter your question">

        <label>Option A</label>
        <input type="text" name="optionA[]" placeholder="Option A">

        <label>Option B</label>
        <input type="text" name="optionB[]" placeholder="Option B">

        <label>Option C</label>
        <input type="text" name="optionC[]" placeholder="Option C">

        <label>Option D</label>
        <input type="text" name="optionD[]" placeholder="Option D">

        <label>Correct Answer</label>
        <select name="correct_answer[]">
            <option value="">Choose Answer</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
        </select>

        <button type="button" class="delete-btn" onclick="deleteQuestion(this)">Delete</button>
    `;

    container.appendChild(div);
}

function deleteQuestion(button) {
    button.parentElement.remove();
}

function updatePreview() {
    document.getElementById('previewTitle').innerText =
        document.getElementById('title').value || 'Quiz Title Preview';

    document.getElementById('previewDescription').innerText =
        document.getElementById('description').value || 'Description preview will appear here';

    document.getElementById('previewCategory').innerText =
        document.getElementById('category').value;

    document.getElementById('previewDifficulty').innerText =
        document.getElementById('difficulty').value || '-';
}

document.getElementById('cover').addEventListener('change', function(e) {
    const file = e.target.files[0];

    if (file) {
        document.getElementById('previewImage').src = URL.createObjectURL(file);
    }
});
</script>

</body>
</html>