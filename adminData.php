<?php
include("db_connect.php");


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <title>View Data Analytics</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            font-family: Segoe UI, sans-serif;
            background: #f4f6fb;
            padding: 40px;
        }

        .header {
            background: #2748A5;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            margin: -40px -40px 30px -40px;
        }

        .logo img {
            height: 50px;
            margin-right: 10px;
        }

        .icons i {
            color: white;
            font-size: 30px;
            cursor: pointer;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 95%;
            margin: auto;
            overflow-x: auto;
        }

        h2 {
            text-align: center;
            color: #2748A5;
        }

        .logout-container{
            text-align:center;
            margin:30px 0 50px;
        }
        
        .logout-btn{
            background:#dc3545;
            color:white;
            border:none;
            padding:12px 35px;
            border-radius:30px;
            font-size:16px;
            cursor:pointer;
            transition:0.3s;
        }
        
        .logout-btn:hover{
            background:#b52a37;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #2748A5;
            color: white;
        }

        .btn {
            padding: 7px 14px;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            margin-bottom: 5px;
        }

        .approve {
            background: green;
        }

        .reject {
            background: red;
        }

        .view-link {
            color: #2748A5;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="logo">
            <img src="images/logoRakan.png" alt="Rakan Akademik Logo">
            <img src="images/logoUtem.png" alt="UTeM Logo">
            <img src="images/logoFtmk.png" alt="FTMK Logo">
        </div>

        <div class="icons">
            <i class="fas fa-home" onclick="location.href='admin_dashboard.php'"></i>
        </div>
    </div>

<div class="container">
    <h2>Student Performance Analytics</h2>

    </div>

</body>

</html>