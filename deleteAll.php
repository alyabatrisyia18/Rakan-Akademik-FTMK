<?php
include "db_connect.php";

$type    = isset($_GET['type'])    ? $_GET['type']    : '';
$subject = isset($_GET['subject']) ? $_GET['subject'] : '';

if($type == 'chapter'){
    $chapter_id = intval($_GET['id']);
    
    $topics = mysqli_query($conn, "SELECT topic_id FROM topics WHERE chapter_id = $chapter_id");
    while($topic = mysqli_fetch_assoc($topics)){
        mysqli_query($conn, "DELETE FROM resources WHERE topic_id = " . $topic['topic_id']);
    }
    mysqli_query($conn, "DELETE FROM topics WHERE chapter_id = $chapter_id");
    mysqli_query($conn, "DELETE FROM chapters WHERE chapter_id = $chapter_id");

} else if($type == 'topic'){
    $topic_id = intval($_GET['id']);

    mysqli_query($conn, "DELETE FROM resources WHERE topic_id = $topic_id");
    mysqli_query($conn, "DELETE FROM topics WHERE topic_id = $topic_id");

} else if($type == 'resource'){
    $resource_id = intval($_GET['id']);

    mysqli_query($conn, "DELETE FROM resources WHERE resource_id = $resource_id");
}

header("Location: subj$subject.php");
exit();
?>

