<?php

$conn = mysqli_connect(
    "127.0.0.1",
    "root",
    "",
    "rakan_akademik.sql",
    3306
);

if(!$conn)
{
    die(mysqli_connect_error());
}

?>