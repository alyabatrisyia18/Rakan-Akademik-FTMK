<?php
include("db_connect.php");

$sql = "SELECT userId, name, email, mobile_phone, role, status FROM user";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <title>User List</title>

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

        .container{
    width:90%;
    margin:30px auto;
    background:white;
    border-radius:15px;
    padding:25px;
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
}

.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.search-box input{
    width:280px;
    padding:10px;
    border:1px solid #ccc;
    border-radius:8px;
}

.filter select{
    padding:10px;
    border-radius:8px;
    border:1px solid #ccc;
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#1f3f98;
    color:white;
    padding:15px;
}

td{
    padding:12px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

tr:nth-child(even){
    background:#f7f7f7;
}

tr:hover{
    background:#eef3ff;
}

.view-btn{
    color:#1f3f98;
    font-size:18px;
    text-decoration:none;
}
   .back-btn{
    text-align:center;
    margin-top:30px;
}

.back-btn a{
    display:inline-block;
    background:#1f3f98;
    color:white;
    text-decoration:none;
    padding:12px 25px;
    border-radius:8px;
    font-weight:bold;
    transition:0.3s;
}

.back-btn a:hover{
    background:#16337d;
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

</header>

<section class="welcome">
    <h1>USER LIST</h1>
</section>

<section class="container">

    <div class="top-bar">

        <div class="search-box">
            <input type="text" placeholder="Search user...">
        </div>

        <div class="filter">
            <select>
                <option>All Users</option>
                <option>Student</option>
                <option>Tutor</option>
            </select>
        </div>

    </div>

    <table>

        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Role</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

       <?php
while($row = mysqli_fetch_assoc($result))
{
?>
<tr>

    <td><?php echo $row['userId']; ?></td>

    <td><?php echo $row['name']; ?></td>

    <td><?php echo $row['email']; ?></td>

    <td><?php echo $row['mobile_phone']; ?></td>

    <td><?php echo $row['role']; ?></td>

    <td><?php echo $row['status']; ?></td>

    <td>
        <a href="#" class="view-btn">
            <i class="fas fa-eye"></i>
        </a>
    </td>

</tr>
<?php
}
?>

    </table>

    <div class="back-btn">

    <a href="admin_dashboard.php">

        <i class="fas fa-arrow-left"></i>

        Back

    </a>
    </div>

</section>

</body>
</html>