<?php
include("db_connect.php");
if(isset($_POST["applicationID"]))
{
    $applicationID = $_POST["applicationID"];

    if(isset($_POST["approve"]))
    {
        $status = "Approved";
    }

    else if(isset($_POST["reject"]))
    {
        $status = "Rejected";
    }

    else
    {
        header("Location: approve_tutor.php");
        exit();
    }

    $sql = "UPDATE tutor_application 
            SET status = '$status'
            WHERE applicationID = '$applicationID'";

    if(mysqli_query($conn, $sql))
    {
        echo "<script>
                alert('Tutor application has been $status');
                window.location.href='approve_tutor.php';
              </script>";
    }

    else
    {
        echo "Error: " . mysqli_error($conn);
    }
}
  else
    {
      header("Location: approve_tutor.php");
      exit();
    }
?>