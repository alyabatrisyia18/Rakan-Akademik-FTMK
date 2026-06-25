<?php
include("db_connect.php");

if(isset($_POST["approve"]))
{
    $matric = $_POST["matric"];

    $sql = "
    UPDATE user 
    SET status = 'Approved'
    WHERE userId = '$matric'
    AND role = 'Tutor'
    ";

    mysqli_query($conn, $sql);

    echo "<script>
            alert('Tutor approved successfully!');
            window.location='approve_tutor.php';
          </script>";
}

else if(isset($_POST["reject"]))
{
    $matric = $_POST["matric"];

    $sql = "
    UPDATE user 
    SET status = 'Rejected'
    WHERE userId = '$matric'
    AND role = 'Tutor'
    ";

    mysqli_query($conn, $sql);

    echo "<script>
            alert('Tutor rejected!');
            window.location='approve_tutor.php';
          </script>";
}
?>