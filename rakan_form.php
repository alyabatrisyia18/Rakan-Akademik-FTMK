<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit();
}

$matricNoTutor = $_SESSION['matric'];

$sql = mysqli_query($conn, "
SELECT tutor.*, user.name, user.email, user.mobile_phone
FROM tutor
INNER JOIN user
ON tutor.matricNoTutor=user.matricNoStudent
WHERE tutor.matricNoTutor='$matricNoTutor'
");

if (mysqli_num_rows($sql) == 0) {
    echo "<script>
    alert('Tutor profile not found.');
    window.location='dashboard.php';
    </script>";
    exit();
}

$data = mysqli_fetch_assoc($sql);

$name = $data['name'];
$programme = $data['programme'];
$institution = $data['institution'];
$currentStatus = $data['currentStatus'];
$academicBackground = $data['academicBackground'];
$academicStrengths = $data['academicStrengths'];
$cgpa = $data['cgpa'];
$availability = $data['availability'];
$contactNumber = $data['mobile_phone'];
$email = $data['email'];
$expertise = $data['expertise'];

if (isset($_POST['btnSubmit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    $programme = mysqli_real_escape_string(
        $conn,
        $_POST['programme']
    );

    $institution = mysqli_real_escape_string(
        $conn,
        $_POST['institution']
    );

    $currentStatus = mysqli_real_escape_string(
        $conn,
        $_POST['currentStatus']
    );

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

    $email = mysqli_real_escape_string(
        $conn,
        $_POST['email']
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

    $updateTutor = mysqli_query($conn, "
UPDATE tutor
SET
programme='$programme',
institution='$institution',
currentStatus='$currentStatus',
academicBackground='$academicBackground',
academicStrengths='$academicStrengths',
cgpa='$cgpa',
expertise='$expertise',
availability='$availability'
WHERE matricNoTutor='$matricNoTutor'
");

    $updateUser = mysqli_query($conn, "
UPDATE user
SET
name='$name',
email='$email',
mobile_phone='$contactNumber'
WHERE matricNoStudent='$matricNoTutor'
");

    if ($updateTutor && $updateUser) {
        echo "<script>

        alert('Profile updated successfully.');

        window.location='rakan_view.php';

        </script>";
    } else {
        echo mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Rakan Akademik Form</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial;
            background: url('images/edubackground.jpg');
            background-size: cover;
        }

        .container {

            width: 1000px;
            margin: 40px auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, .2);
        }

        h2 {

            text-align: center;
            color: #2748A5;
            margin-bottom: 30px;
        }

        .form-row {

            display: flex;
            gap: 20px;
        }

        .left,
        .right {

            flex: 1;
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
            display: flex;
            gap: 20px;
            margin-top: 8px;
        }

        .expertise-card {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border: 1px solid #d9d9d9;
            border-radius: 6px;
            font-weight: normal;
        }

        .expertise-card input {
            width: 18px;
            height: 18px;
            accent-color: #2748A5;
        }

        .expertise-card:hover {
            background: #f8f8f8;
            color: black;
        }

        .button {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-top: 35px;
        }

        .button button {
            width: 170px;
            height: 48px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: .2s;
        }

        .back-btn {
            background: #6c757d;
            color: white;
        }

        .back-btn:hover {
            background: #5a6268;
        }

        button[type="submit"] {
            background: #2748A5;
            color: white;
        }

        button[type="submit"]:hover {
            background: #1d3987;
        }
    </style>

</head>

<body>

    <div class="container">

        <h2>Rakan Akademik Profile</h2>

        <form method="POST">

            <div class="form-row">

                <div class="left">

                    <div class="form-group">

                        <label>Name</label>

                        <input
                            type="text"
                            name="name"
                            value="<?php echo htmlspecialchars($name); ?>"
                            required>

                    </div>

                    <div class="form-group">

                        <label>Programme</label>

                        <input
                            type="text"
                            name="programme"
                            value="<?php echo htmlspecialchars($programme); ?>"
                            required>

                    </div>

                    <div class="form-group">

                        <label>Institution</label>

                        <input
                            type="text"
                            name="institution"
                            value="<?php echo htmlspecialchars($institution); ?>"
                            required>

                    </div>

                    <div class="form-group">

                        <label>Current Status</label>

                        <select
                            name="currentStatus"
                            required>

                            <option value="">-- Select Current Status --</option>

                            <option value="Year 1 Semester 1"
                                <?php if ($currentStatus == "Year 1 Semester 1") echo "selected"; ?>>
                                Year 1 Semester 1
                            </option>

                            <option value="Year 1 Semester 2"
                                <?php if ($currentStatus == "Year 1 Semester 2") echo "selected"; ?>>
                                Year 1 Semester 2
                            </option>

                            <option value="Year 2 Semester 1"
                                <?php if ($currentStatus == "Year 2 Semester 1") echo "selected"; ?>>
                                Year 2 Semester 1
                            </option>

                            <option value="Year 2 Semester 2"
                                <?php if ($currentStatus == "Year 2 Semester 2") echo "selected"; ?>>
                                Year 2 Semester 2
                            </option>

                            <option value="Year 3 Semester 1"
                                <?php if ($currentStatus == "Year 3 Semester 1") echo "selected"; ?>>
                                Year 3 Semester 1
                            </option>

                            <option value="Year 3 Semester 2"
                                <?php if ($currentStatus == "Year 3 Semester 2") echo "selected"; ?>>
                                Year 3 Semester 2
                            </option>

                        </select>

                    </div>

                    <div class="form-group">

                        <label>Academic Background</label>

                        <textarea
                            name="academicBackground"
                            rows="5"
                            required><?php echo htmlspecialchars($academicBackground); ?></textarea>

                    </div>

                    <div class="form-group">

                        <label>Academic Strengths</label>

                        <textarea
                            name="academicStrengths"
                            rows="5"
                            required><?php echo htmlspecialchars($academicStrengths); ?></textarea>

                    </div>

                </div>

                <div class="right">

                    <div class="form-group">

                        <label>CGPA</label>

                        <input
                            type="number"
                            step="0.01"
                            min="3.50"
                            max="4.00"
                            name="cgpa"
                            value="<?php echo htmlspecialchars($cgpa); ?>"
                            required>

                    </div>

                    <div class="form-group">

                        <label>Expertise</label>

                        <?php
                        $selectedExpertise = explode(", ", $expertise);
                        ?>

                        <div class="checkbox-group">

                            <label class="expertise-card">
                                <input
                                    type="checkbox"
                                    name="expertise[]"
                                    value="Programming"
                                    <?php if (in_array("Programming", $selectedExpertise)) echo "checked"; ?>>

                                <span>Programming</span>
                            </label>

                            <label class="expertise-card">
                                <input
                                    type="checkbox"
                                    name="expertise[]"
                                    value="Data Structure Algorithm"
                                    <?php if (in_array("Data Structure Algorithm", $selectedExpertise)) echo "checked"; ?>>

                                <span>Data Structure Algorithm</span>
                            </label>

                        </div>
                    </div>
                    <div class="form-group">

                        <label>Availability</label>

                        <input
                            type="text"
                            name="availability"
                            value="<?php echo htmlspecialchars($availability); ?>"
                            required>

                    </div>

                    <div class="form-group">

                        <label>Contact Number</label>

                        <input
                            type="text"
                            name="contactNumber"
                            value="<?php echo htmlspecialchars($contactNumber); ?>"
                            required>

                    </div>

                    <div class="form-group">

                        <label>Email</label>

                        <input
                            type="email"
                            name="email"
                            value="<?php echo htmlspecialchars($email); ?>"
                            required>

                    </div>

                </div>

            </div>

            <div class="button">

                <button
                    type="button"
                    class="back-btn"
                    onclick="window.location.href='dashboard.php';">

                    Back

                </button>

                <button
                    type="submit"
                    name="btnSubmit">

                    Update Profile

                </button>

            </div>

        </form>

    </div>

</body>

</html>