<?php

$conn = mysqli_connect(
    "127.0.0.1",
    "sofea",
    "abc123",
    "rakan_akademik",
    3307
);

if(!$conn)
{
    die(mysqli_connect_error());
}

?>