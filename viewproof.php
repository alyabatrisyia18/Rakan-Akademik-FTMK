<?php
$file = $_GET['file'];
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>View Proof</title>

<style>

body{
    margin:0;
    background:black;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

img{
    max-width:90%;
    max-height:90%;
}

.close-btn{
    position:fixed;
    top:20px;
    right:25px;
    width:45px;
    height:45px;
    border:none;
    border-radius:50%;
    background:red;
    color:white;
    font-size:24px;
    cursor:pointer;
    font-weight:bold;
}

.close-btn:hover{
    background:#c40000;
}

</style>

</head>

<body>

<button class="close-btn"
onclick="window.location.href='paymentapproval.php'">

✕

</button>

<img src="proof/<?php echo $file; ?>">

</body>

</html>