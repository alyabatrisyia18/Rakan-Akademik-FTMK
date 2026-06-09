<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "quizdb"
);

session_start();

$title = $_SESSION['quiz_title'];
$description = $_SESSION['description'];
$category = $_SESSION['category'];
$difficulty = $_SESSION['difficulty'];

$sql = "INSERT INTO quiz
        (quiz_title,
         description,
         category,
         difficulty)
        VALUES
        ('$title',
         '$description',
         '$category',
         '$difficulty')";

mysqli_query($conn,$sql);

echo "Quiz saved successfully!";
?>