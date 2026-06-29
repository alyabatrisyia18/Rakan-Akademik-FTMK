<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['matric'])) {
    echo "<script>alert('Please login first'); window.location.href='login.php';</script>";
    exit();
}

if (!isset($_GET['quizID'])) {
    echo "<script>alert('Quiz not found'); window.location.href='category.php';</script>";
    exit();
}

$quizID = $_GET['quizID'];
$matricNoStudent = $_SESSION['matric'];

$sqlQuiz = "SELECT * FROM quiz WHERE quizID = ?";
$stmtQuiz = mysqli_prepare($conn, $sqlQuiz);
mysqli_stmt_bind_param($stmtQuiz, "s", $quizID);
mysqli_stmt_execute($stmtQuiz);
$quizResult = mysqli_stmt_get_result($stmtQuiz);
$quiz = mysqli_fetch_assoc($quizResult);

if (!$quiz) {
    echo "<script>alert('Quiz not found'); window.location.href='category.php';</script>";
    exit();
}

$sqlAttempt = "SELECT COUNT(*) AS total_attempt
               FROM quiz_attempts
               WHERE quizID = ? AND matricNoStudent = ?";

$stmtAttempt = mysqli_prepare($conn, $sqlAttempt);

if (!$stmtAttempt) {
    die("SQL Attempt Error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmtAttempt, "ss", $quizID, $matricNoStudent);
mysqli_stmt_execute($stmtAttempt);
$attemptResult = mysqli_stmt_get_result($stmtAttempt);
$attemptData = mysqli_fetch_assoc($attemptResult);

if ($attemptData['total_attempt'] >= $quiz['attempts']) {
    echo "<script>
        alert('You have reached the maximum attempts');
        window.location.href='quiz_list.php?category=" . urlencode($quiz['category']) . "';
    </script>";
    exit();
}

$sqlQuestion = "SELECT * FROM quiz_question WHERE quizID = ?";
$stmtQuestion = mysqli_prepare($conn, $sqlQuestion);

if (!$stmtQuestion) {
    die("SQL Question Error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmtQuestion, "s", $quizID);
mysqli_stmt_execute($stmtQuestion);
$questionResult = mysqli_stmt_get_result($stmtQuestion);

$questions = [];
while ($row = mysqli_fetch_assoc($questionResult)) {
    $questions[] = $row;
}

if (isset($_POST['submit_quiz'])) {
    $score = 0;
    $userAnswers = $_POST['answer'] ?? [];
    $totalQuestion = count($questions);

    foreach ($questions as $question) {
        $questionID = $question['questionID'];

        if (
            isset($userAnswers[$questionID]) &&
            $userAnswers[$questionID] == $question['correct_answer']
        ) {
            $score++;
        }
    }

    // untuk tukar jwpn pljar kpd format json. Array -> [1="A", 2="B"] jadi json -> ["1":"A","2":"B"]
    // perlu tukar sebb aku nak simpan jwpn student dlm database
    $userAnswersJson = json_encode($userAnswers);

    $sqlSave = "INSERT INTO quiz_attempts
            (quizID, matricNoStudent, score, total_question, user_answer)
            VALUES (?, ?, ?, ?, ?)";

    $stmtSave = mysqli_prepare($conn, $sqlSave);

    if (!$stmtSave) {
        die("SQL Save Error: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param(
        $stmtSave,
        "ssiis",
        $quizID,
        $matricNoStudent,
        $score,
        $totalQuestion,
        $userAnswersJson
    );

    mysqli_stmt_execute($stmtSave);

    $attemptID = mysqli_insert_id($conn);

    header("Location: quiz_result.php?attemptID=" . $attemptID);
    exit();
}

$timeLimit = $quiz['time_limit'] * 60;
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($quiz['title']); ?></title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #e9eef5;
            padding: 40px;
        }

        .quiz-container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 18px;
        }

        h1 {
            color: #233f99;
            margin-bottom: 10px;
        }

        .info {
            margin-bottom: 20px;
            font-size: 18px;
        }

        .timer {
            background: #233f99;
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            display: inline-block;
            margin-bottom: 25px;
            font-weight: bold;
        }

        .question-box {
            background: #f1f3f8;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .question-box h3 {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
        }

        button {
            background: #233f99;
            color: white;
            border: none;
            padding: 13px 35px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body>

<div class="quiz-container">
    <h1><?php echo htmlspecialchars($quiz['title']); ?></h1>

    <div class="timer">
        Time Left: <div id="timer"></div>
    </div>

    <form method="POST" id="quizForm">

        <?php $no = 1; ?>

        <?php foreach ($questions as $question) { ?>

            <div class="question-box">
                <h3>
                    <?php echo $no++; ?>.
                    <?php echo htmlspecialchars($question['question']); ?>
                </h3>

                <label>
                    <input type="radio" name="answer[<?php echo $question['questionID']; ?>]" value="A">
                    A. <?php echo htmlspecialchars($question['optionA']); ?>
                </label>

                <label>
                    <input type="radio" name="answer[<?php echo $question['questionID']; ?>]" value="B">
                    B. <?php echo htmlspecialchars($question['optionB']); ?>
                </label>

                <label>
                    <input type="radio" name="answer[<?php echo $question['questionID']; ?>]" value="C">
                    C. <?php echo htmlspecialchars($question['optionC']); ?>
                </label>

                <label>
                    <input type="radio" name="answer[<?php echo $question['questionID']; ?>]" value="D">
                    D. <?php echo htmlspecialchars($question['optionD']); ?>
                </label>
            </div>

        <?php } ?>

        <button type="submit" name="submit_quiz">Submit Quiz</button>

    </form>

</div>

<script>
let timeLeft = <?php echo $timeLimit; ?>;
let timerDisplay = document.getElementById("timer");
let quizForm = document.getElementById("quizForm");

function updateTimer() {
    let minutes = Math.floor(timeLeft / 60);
    let seconds = timeLeft % 60;

    timerDisplay.innerHTML = minutes + ":" + (seconds < 10 ? "0" : "") + seconds; //untuk paparkan masa (contoh: 5:08)

    if (timeLeft <= 0) {
        quizForm.submit();
    }

    timeLeft--;
}

updateTimer();
setInterval(updateTimer, 1000);
</script>

</body>
</html>