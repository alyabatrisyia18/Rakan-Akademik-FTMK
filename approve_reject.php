<?php
include("db_connect.php");

if (!isset($_POST["applicationID"])) {
    header("Location: approve_tutor.php");
    exit();
}

$applicationID = (int)$_POST["applicationID"];

if (isset($_POST["approve"])) {

    $status = "Approved";

    $sql = "
    UPDATE tutor_application
    SET
        status='$status',
        popupStatus='0'
    WHERE applicationID='$applicationID'
    ";

    if (mysqli_query($conn, $sql)) {

        /* Get application information */

        $getApplication = mysqli_query($conn,"
        SELECT *
        FROM tutor_application
        WHERE applicationID='$applicationID'
        ");

        $data = mysqli_fetch_assoc($getApplication);

        $matricNoTutor      = $data['matricNoStudent'];
        $name               = $data['name'];
        $programme          = $data['programme'];
        $institution        = $data['institution'];
        $currentStatus      = $data['currentStatus'];
        $academicBackground = $data['academicBackground'];
        $cgpa               = $data['cgpa'];
        $availability       = $data['availability'];
        $contactNumber      = $data['contactNumber'];
        $email              = $data['email'];
        $expertise          = $data['expertise'];

        $checkTutor = mysqli_query($conn,"
        SELECT *
        FROM tutor
        WHERE matricNoTutor='$matricNoTutor'
        ");

        if(mysqli_num_rows($checkTutor)==0)
        {

            mysqli_query($conn,"
            INSERT INTO tutor
            (
                matricNoTutor,
                name,
                programme,
                institution,
                currentStatus,
                academicBackground,
                cgpa,
                availability,
                contactNumber,
                email,
                matricNoStudent,
                expertise
            )

            VALUES
            (
                '$matricNoTutor',
                '$name',
                '$programme',
                '$institution',
                '$currentStatus',
                '$academicBackground',
                '$cgpa',
                '$availability',
                '$contactNumber',
                '$email',
                '$matricNoTutor',
                '$expertise'
            )
            ");

        }

        $getRole = mysqli_query($conn,"
        SELECT role
        FROM user
        WHERE matricNoStudent='$matricNoTutor'
        ");

        if(mysqli_num_rows($getRole)>0)
        {

            $user = mysqli_fetch_assoc($getRole);

            $currentRole = trim($user['role']);

            if(strpos($currentRole,'Tutor')===false)
            {

                $newRole = $currentRole . ",Tutor";

                mysqli_query($conn,"
                UPDATE user
                SET role='$newRole'
                WHERE matricNoStudent='$matricNoTutor'
                ");

            }

        }

        echo "
        <script>

        alert('Tutor application has been approved.');

        window.location='approve_tutor.php';

        </script>
        ";

    } else {

        echo mysqli_error($conn);

    }

}

elseif(isset($_POST["reject"])){

    $status="Rejected";

    $sql="
    UPDATE tutor_application
    SET
        status='$status',
        popupStatus='0'
    WHERE applicationID='$applicationID'
    ";

    if(mysqli_query($conn,$sql))
    {

        echo "
        <script>

        alert('Tutor application has been rejected.');

        window.location='approve_tutor.php';

        </script>
        ";

    }
    else
    {

        echo mysqli_error($conn);

    }

}

else{

    header("Location: approve_tutor.php");
    exit();

}
?>