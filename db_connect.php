<?php

$conn = mysqli_connect(
    "127.0.0.1",
    "rakanAkademik",
    "abc123",
    "rakan_akademik",
    3306
);

if(!$conn)
{
    die(mysqli_connect_error());
}

?>