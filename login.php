<?php

$username = "";
$password = "";

if(isset($_POST["btnLogin"]))
{
    $username = $_POST["txtUser"];
    $password = $_POST["txtPassword"];

    // nanti sambung semakan database di sini

    if($username == "admin" && $password == "1234")
    {
        echo "<script>alert('Login Successful');</script>";
    }
    else
    {
        echo "<script>alert('Invalid Username or Password');</script>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Rakan Akademik</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Segoe UI,sans-serif;
    background:white;
    overflow:hidden;
}

/* HEADER */

.header{
    height:95px;
    background:#2748A5;
    position:relative;
    overflow:hidden;
}

.headerBackground{
    position:absolute;
    top:22px;
    left:0;

    width:100%;
    height:73px;

    background:url("images/edubackground.jpg");
    background-size:cover;
    background-position:center;

    opacity:0.4;
}

.logoArea{
    position:relative;
    z-index:2;

    height:95px;

    padding-left:25px;
    padding-top:20px;
}

.logoUtem{
    height:50px;
}

.logoFtmk{
    height:48px;
    margin-left:12px;
}

/* CONTENT */

.mainContent{
    height:calc(100vh - 95px);
}

.leftPanel{
    width:50%;
    height:100%;
    float:left;

    position:relative;
    overflow:hidden;
}

.rightPanel{
    width:50%;
    height:100%;
    float:left;

    position:relative;
}

/* SHAPES */

.circleTop{
    width:620px;
    height:430px;

    background:#DCECF8;
    border-radius:50%;

    position:absolute;

    top:100px;
    left:70px;
}

.circleBottom{
    width:430px;
    height:430px;

    background:#DCECF8;
    border-radius:50%;

    position:absolute;

    left:-220px;
    bottom:-220px;
}

/* IMAGE */

.mainImage{
    width:75%;
    max-width:550px;

    position:absolute;

    left:50%;
    top:50%;

    transform:translate(-50%,-50%);
}

.footerText{
    position:absolute;

    width:100%;

    bottom:28px;

    text-align:center;
    font-size:13px;
    color:#666;
}

/* LOGIN */

.loginBox{
    width:430px;

    position:absolute;

    left:50%;
    top:50%;

    transform:translate(-50%,-50%);
}

.logoRakan{
    width:190px;

    display:block;

    margin:auto;
    margin-bottom:60px;
}

.textBox{
    width:100%;

    padding:10px 0;

    border:none;
    border-bottom:1px solid #d6d6d6;

    margin-bottom:25px;
}

.textBox:focus{
    outline:none;
    border-bottom:2px solid #6CB6E9;
}

.passwordBox{
    position:relative;
}

.eyeIcon{
    position:absolute;

    right:10px;
    top:8px;

    cursor:pointer;
}

.optionArea{
    margin-top:10px;
    font-size:14px;
}

.optionArea a{
    float:right;
    text-decoration:none;
    color:#4f84c4;
}

.loginButton{
    width:100%;

    padding:10px;

    margin-top:22px;

    border:none;

    background:#6CB6E9;
    color:white;

    cursor:pointer;
}

.loginButton:hover{
    background:#54A8E2;
}

.signupArea{
    text-align:center;
    margin-top:35px;
}

.signupButton{
    padding:6px 24px;

    margin-left:12px;

    border:none;

    background:#6CB6E9;
    color:white;

    cursor:pointer;
}

.signupButton:hover{
    background:#54A8E2;
}

/* MODAL */

.modal{
    display:none;

    position:fixed;

    left:0;
    top:0;

    width:100%;
    height:100%;

    background:rgba(0,0,0,0.45);
}

.modalBox{
    width:420px;

    background:white;

    position:absolute;

    left:50%;
    top:50%;

    transform:translate(-50%,-50%);
}

.modalHeader{
    padding:15px 20px;
    border-bottom:1px solid #ddd;
}

.closeButton{
    float:right;
    cursor:pointer;
    font-size:22px;
}

.modalBody{
    padding:20px;
}

.registerButton{
    display:block;

    text-align:center;

    padding:15px;

    margin-bottom:15px;

    text-decoration:none;

    border:1px solid #ddd;

    color:#333;
}

.registerButton:hover{
    background:#f5f5f5;
}

/* RESPONSIVE */

@media screen and (max-width:768px)
{
    body{
        overflow:auto;
    }

    .leftPanel,
    .rightPanel{
        width:100%;
        float:none;
    }

    .leftPanel{
        height:450px;
    }

    .loginBox{
        width:90%;

        position:relative;

        left:auto;
        top:auto;

        transform:none;

        margin:40px auto;
    }

    .mainImage{
        width:85%;
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

        <img src="images/logoMain.png" class="mainImage">

        <div class="footerText">
            Copyright © 2026 Rakan Akademik |
            Faculty of Information & Communication Technology
        </div>

    </div>

    <div class="rightPanel">

        <div class="loginBox">

            <img src="images/logoRakan.png" class="logoRakan">

            <form method="POST">

                <input
                    type="text"
                    name="txtUser"
                    class="textBox"
                    placeholder="Student ID / Admin">

                <div class="passwordBox">

                    <input
                        type="password"
                        id="password"
                        name="txtPassword"
                        class="textBox"
                        placeholder="Password">

                    <span
                        class="eyeIcon"
                        onclick="togglePassword()">

                        👁

                    </span>

                </div>

                <div class="optionArea">

                    <label>
                        <input type="checkbox">
                        Remember Me
                    </label>

                    <a href="#">
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

            <h3>Choose To Register</h3>

        </div>

        <div class="modalBody">

            <a href="register_student.php" class="registerButton">
                Register As Student
            </a>

            <a href="register_rakan.php" class="registerButton">
                Register As Rakan Akademik
            </a>

        </div>

    </div>

</div>

<script>

function togglePassword()
{
    var passwordField;

    passwordField =
        document.getElementById("password");

    if(passwordField.type=="password")
    {
        passwordField.type="text";
    }
    else
    {
        passwordField.type="password";
    }
}

function openModal()
{
    document.getElementById("signupModal").style.display="block";
}

function closeModal()
{
    document.getElementById("signupModal").style.display="none";
}

</script>

</body>
</html>