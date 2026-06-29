<?php

include("db_connect.php");

if (isset($_POST["btnRegister"])) {
    $name = mysqli_real_escape_string($conn, trim($_POST["txtName"]));
    $matric = strtoupper(mysqli_real_escape_string($conn, trim($_POST["txtMatric"])));
    $course = mysqli_real_escape_string($conn, trim($_POST["txtCourse"]));
    $email = mysqli_real_escape_string($conn, trim($_POST["txtEmail"]));
    if (strpos(strtolower($email), "@student.utem.edu.my") === false) {
        echo "<script>
    alert('Please use your UTeM student email.');
    window.location='register_student.php';
    </script>";
    die();
        
    }
    $phone = mysqli_real_escape_string($conn, trim($_POST["txtPhone"]));
    $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
    $password = $_POST["txtPassword"];
    $confirmPassword = $_POST["txtConfirmPassword"];

    if ($password != $confirmPassword) {
        echo "<script>
    alert('Password does not match.');
window.location='register_student.php';
    </script>";
    die();
    }

    if (strlen($password) < 8) {
        echo "<script>
    alert('Password must be at least 8 characters.');
    window.location='register_student.php';
    </script>";
    die();
    }

    $check = mysqli_query($conn, "
SELECT *

FROM user

WHERE matricNoStudent='$matric'

OR

email='$email'
    ");

    if (mysqli_num_rows($check) > 0) {
        echo "<script>
        alert('Matric number or email has already been registered.');
       window.location='register_student.php';
    </script>";
    die();
    }

    $hashedPassword = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    mysqli_begin_transaction($conn);

    try {

        mysqli_query($conn, "
        INSERT INTO user
        (
            matricNoStudent,
            name,
            email,
            mobile_phone,
            gender,
            password,
            status,
            role
        )

        VALUES
        (
            '$matric',
            '$name',
            '$email',
            '$phone',
            '$gender',
            '$hashedPassword',
            'Active',
            'Student'
        )
        ");

        mysqli_query($conn, "
        INSERT INTO student
        (
            matricNoStudent,
            course
        )

        VALUES
        (
            '$matric',
            '$course'
        )
        ");

        mysqli_commit($conn);

        echo "
        <script>

        alert('Registration Successful');

        window.location='login.php';

        </script>
        ";
    } catch (Exception $e) {

        mysqli_rollback($conn);

        echo "
        <script>

        alert('Registration Failed');

        </script>
        ";
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Registration</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Segoe UI, sans-serif;
        }

        body {
            background: #fff;
        }


        .header {
            height: 95px;
            background: #2748A5;
            position: relative;
        }

        .headerBackground {
            position: absolute;
            top: 22px;
            left: 0;
            width: 100%;
            height: 73px;
            background: url("images/edubackground.jpg");
            background-size: cover;
            background-position: center;
            opacity: 0.4;
        }

        .logoArea {
            position: relative;
            z-index: 2;
            padding-top: 20px;
            padding-left: 25px;
        }

        .logoUtem {
            height: 50px;
        }

        .logoFtmk {
            height: 48px;
            margin-left: 12px;
        }


        .mainContent {
            width: 100%;
            min-height: calc(100vh - 95px);
            display: flex;
        }


        .leftPanel {
            width: 55%;
            background: #f8fbff;
            position: relative;
        }

        .poster {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }


        .rightPanel {
            width: 45%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fff;
        }

        .registerBox {
            width: 420px;
            background: #EEF3FA;
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            padding: 30px;
        }

        .registerBox h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #222;
        }

        .formLabel {
            display: block;
            margin-bottom: 6px;
            margin-top: 10px;
            font-weight: 500;
        }

        .textBox {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .genderArea {
            margin-top: 8px;
            margin-bottom: 10px;
        }

        .genderArea label {
            margin-right: 25px;
        }

        .registerButton {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            border: none;
            border-radius: 4px;
            background: #2748A5;
            color: white;
            cursor: pointer;
            font-size: 15px;
        }

        .registerButton:hover {
            background: #1d3987;
        }

        .backLogin {
            text-align: center;
            margin-top: 15px;
        }

        .backLogin a {
            text-decoration: none;
            color: #2748A5;
        }

        .backLogin a:hover {
            text-decoration: underline;
        }


        @media screen and (max-width:900px) {

            .mainContent {
                flex-direction: column;
            }

            .leftPanel,
            .rightPanel {
                width: 100%;
            }

            .leftPanel {
                height: 350px;
            }

            .registerBox {
                width: 90%;
                margin: 30px 0;
            }
        }
    </style>

</head>

<body>

    <div class="header">

        <div class="headerBackground"></div>

        <div class="logoArea">

            <img src="images/utem.png" class="logoUtem">

            <img src="images/ftmk.png" class="logoFtmk">

        </div>

    </div>

    <div class="mainContent">

        <div class="leftPanel">

            <img
                src="images/posterRegister.png"
                class="poster">

        </div>

        <div class="rightPanel">

            <div class="registerBox">

                <h2>Sign Up As Student</h2>

                <form method="POST">

                    <label class="formLabel">Name</label>
                    <input
                        type="text"
                        name="txtName"
                        class="textBox"
                        required>

                    <label class="formLabel">Matric Number</label>
                    <input
                        type="text"
                        name="txtMatric"
                        class="textBox"
                        placeholder="Example: B032310123"
                        required>

                    <label class="formLabel">Course</label>
                    <input
                        type="text"
                        name="txtCourse"
                        class="textBox"
                        placeholder="Example: Diploma in Computer Science"
                        required>

                    <label class="formLabel">Email</label>
                    <input
                        type="email"
                        name="txtEmail"
                        class="textBox"
                        placeholder="Example: b032410001@student.utem.edu.my"
                        required>

                    <label class="formLabel">Mobile Phone</label>
                    <input
                        type="text"
                        name="txtPhone"
                        class="textBox"
                        required>

                    <label class="formLabel">Gender</label>

                    <div class="genderArea">

                        <label>
                            <input
                                type="radio"
                                name="gender"
                                value="Male"
                                required>

                            Male
                        </label>

                        <label>
                            <input
                                type="radio"
                                name="gender"
                                value="Female">

                            Female
                        </label>

                    </div>

                    <label class="formLabel">Password</label>
                    <input
                        type="password"
                        name="txtPassword"
                        class="textBox"
                        required>

                    <label class="formLabel">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        name="txtConfirmPassword"
                        class="textBox"
                        required>

                    <input
                        type="submit"
                        name="btnRegister"
                        value="Sign Up"
                        class="registerButton">

                </form>

                <div class="backLogin">

                    <a href="login.php">
                        Back To Login
                    </a>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
