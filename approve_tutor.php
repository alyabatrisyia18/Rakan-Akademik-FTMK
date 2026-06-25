<?php
include("db_connect.php");

$sql = "
SELECT 
    user.userId,
    user.name,
    user.email,
    tutor.expertise
FROM user
INNER JOIN tutor 
ON user.userId = tutor.userID
WHERE user.role = 'Tutor'
AND user.status = 'Pending'
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
    
<head>
    <title>Approve Tutor</title>

    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

body{
    font-family: Segoe UI, sans-serif;
    background:#f4f6fb;
    padding:40px;
}

.header{
    background:#2748A5;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 30px;
    margin:-40px -40px 30px -40px;
}

.logo img{
    height:50px;
    margin-right:10px;
}

.icons i{
    color:white;
    font-size:30px;
    cursor:pointer;
}

.container{
    background:white;
    padding:30px;
    border-radius:10px;
    width:90%;
    margin:auto;
}

h2{
    text-align:center;
    color:#2748A5;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:25px;
}

th,td {
    border:1px solid #ddd;
    padding:12px;
    text-align:left;
}

th{
    background:#2748A5;
    color:white;
}

.btn{
    padding:7px 14px;
    border:none;
    border-radius:5px;
    color:white;
    cursor:pointer;
}

.approve{
    background:green;
}

.reject{
    background:red;
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
    <h2>Tutor Applications</h2>
    <table>
        <tr>
            <th>Matric No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Expertise</th>
            <th>Approve/Reject</th>
        </tr>

        <?php
        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_assoc($result))
            {
        ?>

        <tr>
            <td><?php echo $row["userId"]; ?></td>
            <td><?php echo $row["name"]; ?></td>
            <td><?php echo $row["email"]; ?></td>
            <td><?php echo $row["expertise"]; ?></td>
            <td>

                <form method="POST"
                      action="approve_reject.php"
                      style="display:inline;">

                    <input
                        type="hidden"
                        name="matric"
                        value="<?php echo $row["userId"]; ?>">

                    <input
                        type="submit"
                        name="approve"
                        value="Approve"
                        class="btn approve">
                </form>

                <form method="POST"
                      action="approve_reject.php"
                      style="display:inline;">

                    <input
                        type="hidden"
                        name="matric"
                        value="<?php echo $row["userId"]; ?>">

                    <input
                        type="submit"
                        name="reject"
                        value="Reject"
                        class="btn reject">

                </form>
            </td>
        </tr>
        <?php
            }
        }
        else
        {
        ?>

        <tr>
            <td colspan="5" style="text-align:center;"> No pending tutor applications</td>
        </tr>
        <?php
        }
        ?>
    </table>
</div>

</body>
</html>