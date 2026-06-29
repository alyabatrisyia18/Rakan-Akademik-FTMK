<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['matric'])) {
    echo "<script>alert('Please login first'); window.location.href='login.php';</script>";
    exit();
}

if (!isset($_GET['attemptID'])) {
    echo "<script>alert('Result not found'); window.location.href='category.php';</script>";
    exit();
}

$attemptID = $_GET['attemptID'];
$matricNoStudent = $_SESSION['matric'];

//ambik data attempt/result kuiz student
$sqlAttempt = "SELECT * FROM quiz_attempts 
               WHERE attemptID = ? AND matricNoStudent = ?";
$stmtAttempt = mysqli_prepare($conn, $sqlAttempt);

if (!$stmtAttempt) {
    die("SQL Attempt Error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmtAttempt, "is", $attemptID, $matricNoStudent);
mysqli_stmt_execute($stmtAttempt);
$attemptResult = mysqli_stmt_get_result($stmtAttempt);
$attempt = mysqli_fetch_assoc($attemptResult);

if (!$attempt) {
    echo "<script>alert('Result not found'); window.location.href='category.php';</script>";
    exit();
}

$quizID = $attempt['quizID'];

//tukar jwpn json kpd array
$userAnswers = json_decode($attempt['user_answer'], true);

if (!is_array($userAnswers)) {
    $userAnswers = [];
}

// maklumat kuiz
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

// Ambil semua soalan quiz
$sqlQuestion = "SELECT * FROM quiz_question WHERE quizID = ?";
$stmtQuestion = mysqli_prepare($conn, $sqlQuestion);
mysqli_stmt_bind_param($stmtQuestion, "s", $quizID);
mysqli_stmt_execute($stmtQuestion);
$questionResult = mysqli_stmt_get_result($stmtQuestion);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz Result</title>
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

        .result-container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 18px;
        }

        h1 {
            color: #233f99;
            margin-bottom: 15px;
        }

        .score-box {
            background: #233f99;
            color: white;
            padding: 20px;
            border-radius: 15px;
            font-size: 24px;
            margin-bottom: 25px;
        }

        .question-box {
            background: #f1f3f8;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .correct {
            color: green;
            font-weight: bold;
        }

        .wrong {
            color: red;
            font-weight: bold;
        }

        p {
            margin-bottom: 8px;
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
            margin-top: 15px;
        }
    </style>
</head>

<body>
<div class="result-container">
    <h1><?php echo htmlspecialchars($quiz['title']); ?> Result</h1>

    <div class="score-box">
        Your Score: <?php echo $attempt['score']; ?> / <?php echo $attempt['total_question']; ?>
    </div>

    <?php $no = 1; ?>
    <?php while ($question = mysqli_fetch_assoc($questionResult)) { ?>
        <?php
            $questionID = $question['questionID'];
            //jwpn pelajar
            $userAnswer = isset($userAnswers[$questionID]) ? $userAnswers[$questionID] : "Not answered";

            //jwpn btul (database)
            $correctAnswer = $question['correct_answer'];

            //check jwpn
            $status = ($userAnswer == $correctAnswer) ? "Correct" : "Wrong";
        ?>

        <div class="question-box">
            <h3>
                <?php echo $no++; ?>.
                <?php echo htmlspecialchars($question['question']); ?>
            </h3>

            <p>A. <?php echo htmlspecialchars($question['optionA']); ?></p>
            <p>B. <?php echo htmlspecialchars($question['optionB']); ?></p>
            <p>C. <?php echo htmlspecialchars($question['optionC']); ?></p>
            <p>D. <?php echo htmlspecialchars($question['optionD']); ?></p>
            <br>

            <p><b>Your Answer:</b> <?php echo htmlspecialchars($userAnswer); ?></p>
            <p><b>Correct Answer:</b> <?php echo htmlspecialchars($correctAnswer); ?></p>

            <p class="<?php echo ($status == 'Correct') ? 'correct' : 'wrong'; ?>">
                <?php echo $status; ?>
            </p>
        </div>
    <?php } 
    ?>
    <button onclick="location.href='quiz_list.php?category=<?php echo urlencode($quiz['category']); ?>'">Back to Quiz List
    </button>
</div>

</body>
</html>