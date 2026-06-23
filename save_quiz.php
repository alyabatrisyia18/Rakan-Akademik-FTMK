<?php
session_start();
include 'db_connect.php';

if(!isset($_SESSION['matric'])){
    echo "<script>
        alert('Please login first');
        window.location.href='login.php';
    </script>";
    exit();
}

$quizID = "Q" . time();
$matricNoTutor = $_SESSION['matric'];

$title = $_POST['title'];
$description = $_POST['description'];
$category = $_POST['category'];
$difficulty = $_POST['difficulty'];
$time_limit = $_POST['time_limit'];
$attempts = $_POST['attempts'];
$visibility = $_POST['visibility'];
$show_results = $_POST['show_results'];

$cover = "";

if(isset($_FILES['cover']) && $_FILES['cover']['name'] != ""){
    $cover = "uploads/" . basename($_FILES['cover']['name']);
    move_uploaded_file($_FILES['cover']['tmp_name'], $cover);
}

$sqlQuiz = "INSERT INTO quiz
(quizID, matricNoTutor, title, description, category, difficulty, cover, time_limit, attempts, visibility, show_results)
VALUES
('$quizID', '$matricNoTutor', '$title', '$description', '$category', '$difficulty', '$cover', '$time_limit', '$attempts', '$visibility', '$show_results')";

mysqli_query($conn, $sqlQuiz);

$questions = $_POST['question'];
$optionA = $_POST['optionA'];
$optionB = $_POST['optionB'];
$optionC = $_POST['optionC'];
$optionD = $_POST['optionD'];
$correct_answer = $_POST['correct_answer'];

for($i = 0; $i < count($questions); $i++){
    $sqlQuestion = "INSERT INTO question
    (quizID, question, optionA, optionB, optionC, optionD, correct_answer)
    VALUES
    ('$quizID', '$questions[$i]', '$optionA[$i]', '$optionB[$i]', '$optionC[$i]', '$optionD[$i]', '$correct_answer[$i]')";

    mysqli_query($conn, $sqlQuestion);
}

echo "<script>
    alert('Quiz published successfully!');
    window.location.href='quiz_list.php?category=$category';
</script>";
?>