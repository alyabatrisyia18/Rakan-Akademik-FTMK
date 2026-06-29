<?php
include "db_connect.php";

header('Content-Type: application/json');

$topic_id = isset($_GET['topic_id']) ? intval($_GET['topic_id']) : 0;

if ($topic_id === 0) {
    echo json_encode(['error' => 'Invalid topic_id']);
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM resources WHERE topic_id = $topic_id");

$data = [
    'video'    => [],
    'notes'    => [],
    'tutorial' => [],
];

while ($row = mysqli_fetch_assoc($result)) {
    $type = strtolower($row['type']);
    if (array_key_exists($type, $data)) {
        $data[$type][] = [
            'title' => $row['title'],
            'link'  => $row['link'],
        ];
    }
}

echo json_encode($data);
?>

