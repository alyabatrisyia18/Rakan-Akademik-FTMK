<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "rakan_akademik"
);

if(!$conn)
{
    die("Database Connection Failed");
}

?>