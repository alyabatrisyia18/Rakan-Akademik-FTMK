<?php
session_start();
include("db_connect.php");

if (isset($_POST["btnLogin"])) {
    $username = trim($_POST["txtUser"]);
    $password = $_POST["txtPassword"];

    if ($username == "admin" && $password == "1234") {
        $_SESSION['matric'] = "admin";
        $_SESSION['name'] = "Administrator";
        $_SESSION['role'] = "Admin";

        echo "
        <script>

        alert('Admin Login Successful');

        window.location='admin_dashboard.php';

        </script>
        ";

        exit();
    }

    $sql = mysqli_query($conn, "
    SELECT *
    FROM user
    WHERE matricNoStudent='$username'
    ");

    if (mysqli_num_rows($sql) == 0) {
        echo "
        <script>

        alert('User not found.');
    window.location='login.php';
    </script>";

        exit();
    }

    $row = mysqli_fetch_assoc($sql);

    if (!password_verify($password, $row['password'])) {
        echo "
        <script>

        alert('Wrong Password');
    window.location='login.php';
    </script>";

        exit();
    }

    if (strtolower($row['status']) != "active") {
        echo "
        <script>

        alert('Your account is inactive.');

    window.location='login.php';
    </script>";

        exit();
    }

    $_SESSION['matric'] = $row['matricNoStudent'];
    $_SESSION['name'] = $row['name'];
    $_SESSION['role'] = trim($row['role']);

    $matric = $row['matricNoStudent'];
    $popup = mysqli_query($conn, "
SELECT *
FROM tutor_application
WHERE matricNoStudent='$matric'
AND popupStatus='0'
AND status IN ('Approved','Rejected')
LIMIT 1
");

    if (mysqli_num_rows($popup) > 0) {
        $dataPopup = mysqli_fetch_assoc($popup);

        $_SESSION['popupStatus'] = $dataPopup['status'];

        mysqli_query($conn, "
    UPDATE tutor_application
    SET popupStatus='1'
    WHERE applicationID='" . $dataPopup['applicationID'] . "'
    ");
    }

    $roles = array_map('trim', explode(",", $row['role']));


    if (in_array("Tutor", $roles)) {

        echo "
    <script>

    alert('Login Successful');

    window.location='choose_role.php';

    </script>
    ";
    } else if (in_array("Student", $roles)) {

        echo "
    <script>

    alert('Login Successful');

    window.location='student_dashboard.php';

    </script>
    ";
    } else {

        echo "
    <script>

    alert('Invalid user role.');

    window.location='login.php';

    </script>
    ";
    }

    exit();
}

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <title>Rakan Akademik</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Segoe UI, sans-serif;
            background: white;
            overflow: hidden;
        }

        .header {
            height: 95px;
            background: #2748A5;
            position: relative;
            overflow: hidden;
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
            height: 95px;
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
            height: calc(100vh - 95px);
        }

        .leftPanel {
            width: 50%;
            height: 100%;
            float: left;
            position: relative;
            overflow: hidden;
        }

        .rightPanel {
            width: 50%;
            height: 100%;
            float: left;
            position: relative;
        }

        .circleTop {
            width: 500px;
            height: 350px;
            background: #DCECF8;
            border-radius: 50%;
            position: absolute;
            top: 130px;
            left: 50%;
            transform: translateX(-50%);
        }

        .circleBottom {
            width: 250px;
            height: 250px;
            background: #DCECF8;
            border-radius: 50%;
            position: absolute;
            left: -120px;
            bottom: -120px;
        }

        .mainImage {
            width: 55%;
            max-width: 380px;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .footerText {
            position: absolute;
            bottom: 28px;
            width: 100%;
            text-align: center;
            font-size: 13px;
            color: #666;
        }

        .loginBox {
            width: 430px;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .logoRakan {
            width: 250px;
            display: block;
            margin: auto;
            margin-bottom: 50px;
        }

        .textBox {
            width: 100%;
            padding: 10px 0;
            border: none;
            border-bottom: 1px solid #d6d6d6;
            margin-bottom: 25px;
        }

        .textBox:focus {
            outline: none;
            border-bottom: 2px solid #6CB6E9;
        }

        .passwordBox {
            position: relative;
        }

        .eyeIcon {
            position: absolute;
            right: 10px;
            top: 8px;
            cursor: pointer;
            font-size: 18px;
            color: #666;
        }

        .optionArea {
            margin-top: 10px;
            font-size: 14px;
        }

        .optionArea a {
            float: right;
            text-decoration: none;
            color: #4f84c4;
        }

        .loginButton {
            width: 100%;
            padding: 10px;
            margin-top: 22px;
            border: none;
            background: #6CB6E9;
            color: white;
            cursor: pointer;
        }

        .loginButton:hover {
            background: #54A8E2;
        }

        .signupArea {
            text-align: center;
            margin-top: 35px;
        }

        .signupButton {
            padding: 6px 24px;
            margin-left: 12px;
            border: none;
            background: #6CB6E9;
            color: white;
            cursor: pointer;
        }

        .signupButton:hover {
            background: #54A8E2;
        }

        .modal {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.45);
        }

        .modalBox {
            width: 420px;
            background: white;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .modalHeader {
            padding: 15px 20px;
            border-bottom: 1px solid #ddd;
        }

        .closeButton {
            float: right;
            cursor: pointer;
            font-size: 22px;
        }

        .modalBody {
            padding: 20px;
        }

        .registerButton {
            display: block;
            text-align: center;
            padding: 15px;
            margin-bottom: 15px;
            text-decoration: none;
            border: 1px solid #ddd;
            color: #333;
        }

        .registerButton:hover {
            background: #f5f5f5;
        }


        @media screen and (max-width:768px) {

            body {
                overflow: auto;
            }

            .leftPanel,
            .rightPanel {
                width: 100%;
                float: none;
            }

            .leftPanel {
                height: 350px;
            }

            .circleTop {
                width: 320px;
                height: 220px;
                top: 70px;
            }

            .circleBottom {
                width: 180px;
                height: 180px;
                left: -90px;
                bottom: -90px;
            }

            .mainImage {
                width: 70%;
                max-width: 250px;
            }

            .loginBox {
                width: 90%;
                position: relative;
                left: auto;
                top: auto;
                transform: none;
                margin: 40px auto;
            }

            .logoRakan {
                width: 180px;
                margin-bottom: 35px;
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

            <div class="circleTop"></div>

            <div class="circleBottom"></div>

            <img
                src="images/logoMain.png"
                class="mainImage">

            <div class="footerText">

                Copyright ©️ 2026 Rakan Akademik |
                Faculty of Information & Communication Technology

            </div>

        </div>

        <div class="rightPanel">

            <div class="loginBox">

                <img
                    src="images/logoRakan.png"
                    class="logoRakan">

                <form method="POST">

                    <input

                        type="text"

                        name="txtUser"

                        class="textBox"

                        placeholder="Matric Number"

                        required>

                    <div class="passwordBox">

                        <input

                            type="password"

                            id="password"

                            name="txtPassword"

                            class="textBox"

                            placeholder="Password"

                            required>

                        <span

                            class="eyeIcon glyphicon glyphicon-eye-close"

                            onclick="togglePassword()">

                        </span>

                    </div>

                    <div class="optionArea">

                        <a href="forgot_password.php">

                            Forgot Password?

                        </a>

                    </div>

                    <input

                        type="submit"

                        name="btnLogin"

                        value="Log In"

                        class="loginButton">

                </form>

                <div class="signupArea">

                    Don't have an account?

                    <button

                        class="signupButton"

                        onclick="openModal()">

                        Sign Up

                    </button>

                </div>

            </div>

        </div>

    </div>
    <div id="signupModal" class="modal">

        <div class="modalBox">

            <div class="modalHeader">

                <span
                    class="closeButton"
                    onclick="closeModal()">

                    &times;

                </span>

                <h3>Register As Student</h3>

            </div>

            <div class="modalBody">

                <a
                    href="register_student.php"
                    class="registerButton">

                    Register As Student

                </a>

            </div>

        </div>

    </div>

    <script>
        function togglePassword() {
            var passwordField =
                document.getElementById("password");

            var eyeIcon =
                document.querySelector(".eyeIcon");

            if (passwordField.type == "password") {
                passwordField.type = "text";

                eyeIcon.classList.remove("glyphicon-eye-close");
                eyeIcon.classList.add("glyphicon-eye-open");
            } else {
                passwordField.type = "password";

                eyeIcon.classList.remove("glyphicon-eye-open");
                eyeIcon.classList.add("glyphicon-eye-close");
            }
        }

        function openModal() {
            document.getElementById("signupModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("signupModal").style.display = "none";
        }

        window.onclick = function(event) {
            var modal = document.getElementById("signupModal");

            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</body>

</html>