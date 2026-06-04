<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Rakan Akademik</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Segoe UI',sans-serif;
    background:white;
    overflow:hidden;
}

/* ================= HEADER ================= */

.header{
    height:95px;
    background:#2748A5;
    position:relative;
    overflow:hidden;
}

.header-doodle{
    position:absolute;

    top:22px;
    left:0;

    width:100%;
    height:73px;

    background:url("images/edubackground.jpg");
    background-size:cover;
    background-position:center;

    opacity:0.40;
}

.header-logo{
    position:relative;
    z-index:3;

    display:flex;
    align-items:center;

    height:100%;

    padding-left:25px;
    padding-top:8px;
}

.utem-logo{
    height:48px;
    width:auto;
}

.ftmk-logo{
    height:48px;
    width:auto;
    margin-left:12px;
}

/* ================= CONTENT ================= */

.main-content{
    height:calc(100vh - 95px);
}

/* ================= LEFT PANEL ================= */

.left-panel{
    background:white;
    position:relative;
    overflow:hidden;
}

/* Coral Shape */

.coral-top{
    position:absolute;

    width:620px;
    height:430px;

    background:#DCECF8;

    border-radius:50%;

    top:100px;
    left:70px;

    z-index:1;
}

.coral-bottom{
    position:absolute;

    width:430px;
    height:430px;

    background:#DCECF8;

    border-radius:50%;

    left:-220px;
    bottom:-220px;

    z-index:1;
}

/* Main Illustration */

.main-image{

    width:75%;
    max-width:550px;

    position:absolute;

    left:50%;
    top:50%;

    transform:translate(-50%,-50%);

    z-index:2;
}

/* Copyright */

.footer-text{

    position:absolute;

    width:100%;

    bottom:28px;

    text-align:center;

    font-size:13px;

    color:#666;

    z-index:3;
}

/* ================= RIGHT PANEL ================= */

.right-panel{

    background:white;

    display:flex;
    justify-content:center;
    align-items:center;
}

.login-container{
    width:430px;
}

/* Logo Rakan Akademik */

.logo-rakan{

    width:190px;

    display:block;

    margin:auto;

    margin-bottom:60px;
}

/* Input */

.form-control{

    border:none;

    border-bottom:1px solid #d6d6d6;

    border-radius:0;
}

.form-control:focus{

    box-shadow:none;

    border-bottom:2px solid #6CB6E9;
}

/* Password */

.password-wrapper{
    position:relative;
}

.password-wrapper span{

    position:absolute;

    right:10px;
    top:10px;

    cursor:pointer;

    font-size:18px;
}

/* Remember Me */

.login-options{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-top:15px;

    font-size:14px;
}

.login-options a{

    text-decoration:none;

    color:#4f84c4;
}

/* Login Button */

.btn-login{

    width:100%;

    margin-top:22px;

    background:#6CB6E9;

    border:none;

    color:white;

    padding:10px;
}

.btn-login:hover{
    background:#54A8E2;
}

/* Sign Up */

.signup-section{

    text-align:center;

    margin-top:35px;
}

.btn-signup{

    background:#6CB6E9;

    border:none;

    color:white;

    margin-left:12px;

    padding:6px 24px;
}

.btn-signup:hover{
    background:#54A8E2;
}

</style>

</head>

<body>

<!-- HEADER -->

<div class="header">

    <div class="header-doodle"></div>

    <div class="header-logo">

        <img src="images/utem.png" class="utem-logo">

        <img src="images/ftmk.png" class="ftmk-logo">

    </div>

</div>

<!-- CONTENT -->

<div class="container-fluid">

<div class="row main-content">

    <!-- LEFT -->

    <div class="col-md-6 left-panel">

        <div class="coral-top"></div>

        <div class="coral-bottom"></div>

        <img src="images/logoMain.png"
             class="main-image">

        <div class="footer-text">

            Copyright © 2026 Rakan Akademik |
            Faculty of Information & Communication Technology

        </div>

    </div>

    <!-- RIGHT -->

    <div class="col-md-6 right-panel">

        <div class="login-container">

            <img src="images/logoRakan.png"
                 class="logo-rakan">

            <form method="POST">

                <input
                    type="text"
                    class="form-control mb-4"
                    placeholder="Student ID / Admin">

                <div class="password-wrapper">

                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        placeholder="Password">

                    <span onclick="togglePassword()">
                        👁
                    </span>

                </div>

                <div class="login-options">

                    <label>
                        <input type="checkbox">
                        Remember Me
                    </label>

                    <a href="#">
                        Forgot Password?
                    </a>

                </div>

                <button
                    type="submit"
                    class="btn btn-login">

                    Log In

                </button>

            </form>
            
            <div class="signup-section">
                Don't have an account?
                <button type="button" class="btn btn-signup" data-bs-toggle="modal" data-bs-target="#signupModal">
                    Sign Up
                </button>
            </div>

        </div>

    </div>

</div>

</div>
<!-- MODAL SIGNUP -->

<div class="modal fade"
     id="signupModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Choose To Register
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <div class="d-grid gap-3">

                    <a href="register_student.php"
                       class="btn btn-outline-primary p-3">

                        👤 Register As Student

                    </a>

                    <a href="register_rakan.php"
                       class="btn btn-outline-success p-3">

                        👨‍🏫 Register As Rakan Akademik

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<script> 

function togglePassword(){ 
    let password = document.getElementById("password"); 
    
    if(password.type==="password"){ 
        
    password.type="text"; 

    }

    else{ 

        password.type="password";

    }
} 

</script> 

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>