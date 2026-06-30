<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit();
}

$matricNoStudent = $_SESSION['matric'];
$email = strtolower($matricNoStudent) . "@student.utem.edu.my";

$getUser = mysqli_query($conn, "
SELECT *
FROM user
WHERE matricNoStudent='$matricNoStudent'
");

if (mysqli_num_rows($getUser) == 0) {
    echo "<script>
    alert('User not found.');
    window.location='login.php';
    </script>";
    exit();
}

$user = mysqli_fetch_assoc($getUser);

$getStudent = mysqli_query($conn, "
SELECT *
FROM student
WHERE matricNoStudent='$matricNoStudent'
");

if (mysqli_num_rows($getStudent) == 0) {
    echo "<script>
    alert('Student record not found.');
    window.location='student_dashboard.php';
    </script>";
    exit();
}

$student = mysqli_fetch_assoc($getStudent);

$name = $user['name'];
$email = $user['email'];
$contactNumber = $user['mobile_phone'];
$programme = $student['course'];

$checkApplication = mysqli_query($conn, "
SELECT *
FROM tutor_application
WHERE matricNoStudent='$matricNoStudent'
AND
(
status='Pending'
OR status='Approved'
)
");

if (mysqli_num_rows($checkApplication) > 0) {
    $row = mysqli_fetch_assoc($checkApplication);

    if ($row['status'] == "Pending") {
        echo "<script>
        alert('You already have a pending application.');
        window.location='student_dashboard.php';
        </script>";
        exit();
    }

    if ($row['status'] == "Approved") {
        echo "<script>
        alert('You are already a Rakan Akademik.');
        window.location='student_dashboard.php';
        </script>";
        exit();
    }
}

if (isset($_POST['btnSubmit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $programme = mysqli_real_escape_string($conn, $_POST['programme']);
    $institution = mysqli_real_escape_string($conn, $_POST['institution']);
    $currentStatus = mysqli_real_escape_string($conn, $_POST['currentStatus']);

    $academicBackground = mysqli_real_escape_string(
        $conn,
        $_POST['academicBackground']
    );

    $academicStrengths = mysqli_real_escape_string(
        $conn,
        $_POST['academicStrengths']
    );

    $cgpa = (float)$_POST['cgpa'];

    $availability = mysqli_real_escape_string(
        $conn,
        $_POST['availability']
    );

    $contactNumber = mysqli_real_escape_string(
        $conn,
        $_POST['contactNumber']
    );

    $email = strtolower($matricNoStudent) . "@student.utem.edu.my";

    $reason = mysqli_real_escape_string(
        $conn,
        $_POST['reason']
    );

    if ($cgpa < 3.50 || $cgpa > 4.00) {
        echo "<script>
        alert('CGPA must be between 3.50 and 4.00');
        </script>";
        exit();
    }

    if (empty($_POST['expertise'])) {
        echo "<script>
        alert('Please select at least one expertise.');
        </script>";
        exit();
    }

    $expertise = implode(", ", $_POST['expertise']);

    if (empty($_FILES['transcript']['name'])) {
        echo "<script>
        alert('Please upload your transcript.');
        </script>";
        exit();
    }

    $extension = strtolower(
        pathinfo(
            $_FILES['transcript']['name'],
            PATHINFO_EXTENSION
        )
    );

    if ($extension != "pdf") {
        echo "<script>
        alert('Only PDF file is allowed.');
        </script>";
        exit();
    }

    if ($_FILES['transcript']['size'] > 5000000) {
        echo "<script>
        alert('Maximum file size is 5MB.');
        </script>";
        exit();
    }

    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }

    $safeName = preg_replace(
        '/\s+/',
        '_',
        $_FILES['transcript']['name']
    );

    $fileName = time() . "_" . $safeName;

    if (!move_uploaded_file(
        $_FILES['transcript']['tmp_name'],
        "uploads/" . $fileName
    )) {
        echo "<script>
        alert('Failed to upload transcript.');
        </script>";
        exit();
    }

    $sql = "
    INSERT INTO tutor_application
    (
        matricNoStudent,
        name,
        programme,
        institution,
        currentStatus,
        academicBackground,
        academicStrengths,
        cgpa,
        expertise,
        availability,
        contactNumber,
        email,
        reason,
        transcript,
        status
    )

    VALUES
    (
        '$matricNoStudent',
        '$name',
        '$programme',
        '$institution',
        '$currentStatus',
        '$academicBackground',
        '$academicStrengths',
        '$cgpa',
        '$expertise',
        '$availability',
        '$contactNumber',
        '$email',
        '$reason',
        '$fileName',
        'Pending'
    )";

    if (mysqli_query($conn, $sql)) {
        echo "
        <script>

        alert('Application submitted successfully.');

        window.location='student_dashboard.php';

        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Register Rakan Akademik</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial;
            background: url('images/edubackground.jpg');
            background-size: cover;
        }

        .container {
            width: 900px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, .2);
        }

        h2 {
            text-align: center;
            color: #2748A5;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        input,
        textarea,
        select {

            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        .checkbox-group {

            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 10px;
        }

        .checkbox-group label {

            font-weight: normal;
        }

        .button-group {

            text-align: center;
            margin-top: 30px;
        }

        .btn {

            background: #2748A5;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {

            background: #18357d;
        }
    </style>

</head>

<body>

    <div class="container">

        <h2>Register As Rakan Akademik</h2>

        <form
            method="POST"
            enctype="multipart/form-data">

            <div class="form-group">

                <label>Name</label>

                <input
                    type="text"
                    name="name"
                    value="<?php echo htmlspecialchars($name); ?>"
                    readonly>

            </div>

            <div class="form-group">

                <label>Programme</label>

                <input
                    type="text"
                    name="programme"
                    value="<?php echo htmlspecialchars($programme); ?>"
                    readonly>

            </div>

            <div class="form-group">

                <label>Institution</label>

                <input
                    type="text"
                    name="institution"
                    required>

            </div>

            <div class="form-group">

                <label>Current Status</label>

                <input
                    type="text"
                    name="currentStatus"
                    required>

            </div>

            <div class="form-group">

                <label>Academic Background</label>

                <textarea
                    name="academicBackground"
                    rows="4"
                    required></textarea>

            </div>

            <div class="form-group">

                <label>Academic Strengths</label>

                <textarea
                    name="academicStrengths"
                    rows="4"
                    required></textarea>

            </div>

            <div class="form-group">

                <label>CGPA</label>

                <input
                    type="number"
                    step="0.01"
                    min="3.50"
                    max="4.00"
                    name="cgpa"
                    required>

            </div>

            <div class="form-group">

                <label>Expertise</label>

                <div class="checkbox-group">

                    <label>
                        <input
                            type="checkbox"
                            name="expertise[]"
                            value="Programming">
                        Programming
                    </label>

                    <label>
                        <input
                            type="checkbox"
                            name="expertise[]"
                            value="Data Structure">
                        Data Structure
                    </label>

                </div>

            </div>
            <div class="form-group">

                <label>Availability</label>

                <input
                    type="text"
                    name="availability"
                    placeholder="Example: Monday - Friday (8.00PM - 10.00PM)"
                    required>

            </div>

            <div class="form-group">

                <label>Contact Number</label>

                <input
                    type="text"
                    name="contactNumber"
                    value="<?php echo htmlspecialchars($contactNumber); ?>"
                    readonly>

            </div>

            <div class="form-group">

                <label>Email</label>

                <input
    type="email"
    name="email"
    value="<?php echo strtolower($matricNoStudent); ?>@student.utem.edu.my"
    readonly>

            </div>

            <div class="form-group">

                <label>Reason To Become Rakan Akademik</label>

                <textarea
                    name="reason"
                    rows="5"
                    required
                    placeholder="State why you would like to become a Rakan Akademik..."></textarea>

            </div>

            <div class="form-group">

                <label>Upload Transcript (PDF Only)</label>

                <input
                    type="file"
                    name="transcript"
                    accept=".pdf"
                    required>

            </div>

            <div class="button-group">

                <button
                    type="submit"
                    name="btnSubmit"
                    class="btn">

                    Submit Application

                </button>
                <button
                    type="button"
                    name="btnBack"
                    class="btn"
                    onclick="window.location.href='student_dashboard.php';">

                    Back

                </button>

            </div>

        </form>

    </div>

</body>

</html>