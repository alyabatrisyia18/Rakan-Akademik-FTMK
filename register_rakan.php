<?php
session_start();
include("db_connect.php");

if(!isset($_SESSION['userId']))
{
    header("Location: login.php");
    exit();
}
$userId = mysqli_real_escape_string($conn, $_SESSION['userId']);
$checkStudent = mysqli_query(
    $conn,
    "SELECT matricNoStudent
     FROM student
     WHERE userID='$userId'"
);

if(mysqli_num_rows($checkStudent) == 0)
{
    echo "<script>
    alert('Student record not found.');
    window.location='login.php';
    </script>";
    exit();
}

$student = mysqli_fetch_assoc($checkStudent);
$matricNoStudent = $student['matricNoStudent'];

$sqlRole = mysqli_query(
    $conn,
    "SELECT role
     FROM user
     WHERE userId='$userId'"
);

if(!$sqlRole)
{
    die(mysqli_error($conn));
}

if(mysqli_num_rows($sqlRole) == 0)
{
    session_destroy();
    header("Location: login.php");
    exit();
}

$dataRole = mysqli_fetch_assoc($sqlRole);

$roles = array_map(
    'trim',
    explode(',', $dataRole['role'])
);

if(in_array("Tutor",$roles))
{
    echo "<script>
    alert('You are already a Rakan Akademik.');
    window.location='dashboard.php';
    </script>";
    exit();
}

if(!in_array("Student",$roles))
{
    echo "<script>
    alert('Only students can apply.');
    window.location='login.php';
    </script>";
    exit();
}

if(isset($_POST["btnSubmit"]))
{
    $cgpa = (float) $_POST["cgpa"];

    $availability = mysqli_real_escape_string(
        $conn,
        $_POST["availability"]
    );

    $reason = mysqli_real_escape_string(
        $conn,
        $_POST["reason"]
    );

    if($cgpa < 3.50 || $cgpa > 4.00)
    {
        echo "<script>
        alert('CGPA must be between 3.50 and 4.00');
        </script>";
        exit();
    }

    if(empty($_POST["expertise"]))
    {
        echo "<script>
        alert('Please select at least one expertise subject.');
        </script>";
        exit();
    }

    $expertise = implode(", ", $_POST["expertise"]);

    $check = mysqli_query(
        $conn,
        "SELECT *
         FROM tutor_application
         WHERE matricNoStudent='$matricNoStudent'
         AND
         (
            status='Pending'
            OR status='Approved'
         )"
    );

    if(mysqli_num_rows($check) > 0)
    {
        $application = mysqli_fetch_assoc($check);

        if($application["status"] == "Pending")
        {
            echo "<script>
            alert('You already have a pending application.');
            </script>";
        }
        else
        {
            echo "<script>
            alert('You are already a Rakan Akademik.');
            </script>";
        }

        exit();
    }

    if(empty($_FILES["transcript"]["name"]))
    {
        echo "<script>
        alert('Transcript is required.');
        </script>";
        exit();
    }

    $fileExt = strtolower(
        pathinfo(
            $_FILES["transcript"]["name"],
            PATHINFO_EXTENSION
        )
    );

    if($fileExt != "pdf")
    {
        echo "<script>
        alert('Only PDF file is allowed.');
        </script>";
        exit();
    }

    if($_FILES["transcript"]["size"] > 5000000)
    {
        echo "<script>
        alert('Maximum file size is 5MB.');
        </script>";
        exit();
    }

    if(!is_dir("uploads"))
    {
        mkdir("uploads",0777,true);
    }

    $safeName = preg_replace(
        '/\s+/',
        '_',
        $_FILES["transcript"]["name"]
    );

    $fileName = time()."_".$safeName;

    if(!move_uploaded_file(
        $_FILES["transcript"]["tmp_name"],
        "uploads/".$fileName
    ))
    {
        echo "<script>
        alert('Failed to upload transcript.');
        </script>";
        exit();
    }
    
    $sql = "
    INSERT INTO tutor_application
    (
        matricNoStudent,
        cgpa,
        expertise,
        availability,
        reason,
        transcript,
        status
    )
    VALUES
    (
        '$matricNoStudent',
        '$cgpa',
        '$expertise',
        '$availability',
        '$reason',
        '$fileName',
        'Pending'
    )";

    if(mysqli_query($conn, $sql))
    {
        echo "<script>
        alert('Application Submitted Successfully.');
        window.location='student_dashboard.php';
        </script>";
    }
    else
    {
        echo "<script>
        alert('Failed to submit application.');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Apply Rakan Akademik</title>

<style>
body{
    font-family: 'Segoe UI', sans-serif;
    margin:0;
    padding:0;
    background: url('images/edubackground.jpg');
    background-size: cover;
}

body::before{
    content:"";
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.35);
    z-index:-1;
}

.container{
    width:650px;
    margin:60px auto;
    background:rgba(255,255,255,0.95);
    padding:35px;
    border-radius:16px;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
    backdrop-filter: blur(5px);
}

h2{
    text-align:center;
    color:#2748A5;
    margin-bottom:25px;
    font-size:26px;
    font-weight:700;
}

label{
    font-weight:600;
    color:#333;
    display:block;
    margin-top:12px;
}

input, textarea{
    width:100%;
    padding:12px;
    margin-top:6px;
    margin-bottom:15px;
    border:1px solid #ddd;
    border-radius:8px;
    font-size:14px;
    transition:0.2s;
}

input:focus, textarea:focus{
    outline:none;
    border-color:#2748A5;
    box-shadow:0 0 5px rgba(39,72,165,0.3);
}

/* checkbox style */
input[type="checkbox"]{
    width:auto;
    margin-right:8px;
    transform: scale(1.1);
}

button{
    padding:12px 18px;
    border:none;
    cursor:pointer;
    border-radius:8px;
    font-weight:600;
    transition:0.2s;
}

.submit{
    background:#2748A5;
    color:white;
    width:100%;
    margin-top:10px;
}

.submit:hover{
    background:#1d3987;
    transform: translateY(-2px);
}

.reset{
    background:#e0e0e0;
    color:#333;
    width:100%;
    margin-top:8px;
}

.reset:hover{
    background:#cfcfcf;
}

.checkbox-group{
    background:#f7f9ff;
    padding:12px;
    border-radius:10px;
    border:1px solid #e6e6e6;
}
</style>
</head>

<body>

<div class="container">

<h2>Apply as Rakan Akademik</h2>

<form
method="POST"
enctype="multipart/form-data"
autocomplete="off">

<label>Matric Number</label>
<input type="text" value="<?php echo $matricNoStudent; ?>" readonly>

<label>CGPA</label>
<input type="number" name="cgpa" step="0.01" min="3.50" max="4.00" required>

<label>Expertise Subject</label>

<div class="checkbox-group">
    <label><input type="checkbox" name="expertise[]" value="Programming"> Programming</label>
    <label><input type="checkbox" name="expertise[]" value="Data Structure"> Data Structure</label>
</div>

<label>Availability</label>
<input type="text" name="availability" required>

<label>Reason to Become Tutor</label>
<textarea name="reason" rows="5" required></textarea>

<label>Upload Transcript (PDF only)</label>
<input type="file" name="transcript" accept=".pdf" required>

<button type="submit" name="btnSubmit" class="submit">Submit</button>
<button type="reset" class="reset">Reset</button>

</form>

</div>

</body>
</html>