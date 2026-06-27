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
    right:20px;

    color:white;
    font-size:35px;
    text-decoration:none;
    font-weight:bold;
}

.close-btn:hover{
    color:#ff4d4d;
}

</style>

</head>

<body>

<a href="paymenthistory.php" class="close-btn">✖</a>

<img src="proof/<?php echo $file; ?>">

</body>

</html>