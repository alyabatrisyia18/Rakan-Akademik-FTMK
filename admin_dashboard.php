<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <title>Admin Dashboard</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, sans-serif;
        }

        body{
            background-image:url('images/edubackground.jpg');
            background-size:cover;
            background-position:center;
            background-repeat:no-repeat;
            background-attachment:fixed;
        }

        header{
            background:#1f3f98;
            color:white;
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:15px 30px;
        }

        .icons i{
            font-size:24px;
            margin-left:20px;
            cursor:pointer;
        }

        .icons{
            display:flex;
            align-items:center;
        }

        .logout-btn{
            background:#ff4d4f;
            color:white;
            border:none;
            border-radius:30px;
            padding:10px 20px;
            font-size:15px;
            font-weight:600;
            display:flex;
            align-items:center;
            gap:8px;
            cursor:pointer;
            transition:0.3s;
        }

        .logout-btn:hover{
            background:#d9363e;
            transform:translateY(-2px);
        }

        .logo img{
            height:60px;
            width:auto;
        }

        .welcome{
            background:#284db6;
            color:white;
            text-align:center;
            padding:20px;
        }

        .welcome h1{
            font-size:32px;
        }

        .menu-container{
            width:85%;
            margin:30px auto;
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:25px;
        }

        .card{
            background:white;
            border:2px solid #ddd;
            border-radius:20px;
            text-align:center;
            padding:30px;
            cursor:pointer;
            transition:0.3s;
        }

        .card:hover{
            transform:translateY(-5px);
            box-shadow:0 5px 15px rgba(0,0,0,0.2);
        }

        .card img{
            width:180px;
            height:180px;
            object-fit:contain;
        }

        .card h2{
            margin-top:15px;
            color:#1f3f98;
        }

        

    </style>

</head>

<body>

<header>

    <div class="logo">
        <img src="images/logoRakan.png" alt="Rakan Akademik Logo">
        <img src="images/logoUtem.png" alt="UTeM Logo">
        <img src="images/logoFtmk.png" alt="FTMK Logo">
    </div>

    <div class="icons">
    <button class="logout-btn" onclick="logout()">
        <i class="fas fa-right-from-bracket"></i>
        Logout
    </button>
    </div>

</header>

<section class="welcome">
    <h1>WELCOME ADMIN</h1>
</section>

<section class="menu-container">

   <div class="card" onclick="location.href='user_list.php'">

    <img src="images/manageuser.jpg" alt="">

    <h2>User List</h2>

</div>

    <div class="card" onclick="location.href='approve_tutor.php'">
        <img src="images/application.jpg" alt="">
        <h2>Tutor Approvals</h2>
    </div>

    <div class="card" onclick="location.href='paymentapproval.php'">
        <img src="images/managetutor.jpg" alt="">
        <h2>Payment Approvals</h2>
    </div>

    <div class="card">
        <img src="images/timetable.jpg" alt="">
        <h2>View Bookings</h2>
    </div>

</section>

<script>

function logout(){

    if(confirm("Are you sure you want to logout?")){

        alert("Logout Successful");
        window.location.href = "logout.php";

    }

}

</script>

</body>
</html>