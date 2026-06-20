<?php
session_start();

if(isset($_POST['save_details']))
{
    $_SESSION['quiz_title'] = $_POST['quiz_title'];
    $_SESSION['description'] = $_POST['description'];
    $_SESSION['category'] = $_POST['category'];
    $_SESSION['difficulty'] = $_POST['difficulty'];

    // handle cove img
    if(isset($_FILES['cover']) && $_FILES['cover']['error'] == 0)
    {
        $imgName = time() . "_" . $_FILES['cover']['name'];
        $target = "uploads/" . $imgName;

        // if folde doesnt exits
        if(!file_exists("uploads")){
            mkdir("uploads", 0777, true);
        }

        move_uploaded_file($_FILES['cover']['tmp_name'], $target);

        $_SESSION['cover'] = $target;
    }
    header("Location: quiz.php?page=questions");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create New Quiz</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
<style>
    *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, sans-serif;
        }

        body{
            background:#e9eef5;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        header{
            background:#1f3f98;
            color:white;
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:15px 30px;
        }

        .search-box{
            width:40%;
            position:relative;
        }

        .search-box input{
            width:100%;
            padding:10px 40px 10px 15px;
            border:none;
            border-radius:30px;
        }

        .search-box i{
            position:absolute;
            right:15px;
            top:50%;
            transform:translateY(-50%);
            color:gray;
        }

        .icons i{
            font-size:24px;
            margin-left:20px;
            cursor:pointer;
        }

        .logo img{
            height:60px;   /* ubah ikut saiz yang nak */
            width:auto;
        }
        
        .main-container{
            display:flex;
            gap:30px;
            padding:20px;
            align-items:flex-start;
        }

        .form-area{
            flex:2;
        }
        
        .preview-area{
            flex:1;
            position:sticky;
            top:20px;
        }
        
        .tabs{
            display:flex;
            gap:15px;
            margin-bottom:25px;
        }
        
        .tab{
            background:#dcdcdc;
            padding:12px 25px;
            border-radius:25px;
            cursor:pointer;
            font-size:14px;
            min-width:180px;
        }

        .tab.active{
            background:#1f3f98;
            color:white;
        }
        
        .tab .num
        {
            font-weight:bold;
            margin-right:10px;
        }

        .page{
            display:none;
        }

        .page.show
        {
            display:block;
        }
        
        .page label{
            display:block;
            margin-top:15px;
            margin-bottom:8px;
            font-weight:bold;
        }

        .page input[type=text],
        .page input[type=number],
        .page textarea,
        .page select,
        .page input[type=file]
        {
            width:100%;
            padding:12px;
            border:1px solid #ccc;
            border-radius:10px;
        }
        
        .page textarea{
            height:100px;
            resize:none;
        }

        .difficulty-inline{
            display:flex;
            gap:10px;
        }
        
        .difficulty-inline input[type=radio]{
            display:none;
        }
        
        .difficulty-inline label{
            background:#dcdcdc;
            padding:10px 20px;
            border-radius:20px;
            cursor:pointer;
            margin-top:0;
        }
        
        .difficulty-inline input[type=radio]:checked + label{
            background:#1f3f98;
            color:white;
        }
        
        button{
            background:#1f3f98;
            color:white;
            border:none;
            padding:12px 30px;
            border-radius:25px;
            cursor:pointer;
        }
        
        button:hover{
            opacity:0.9;
        }
        
        .preview-card{
            background:white;
            border-radius:15px;
            padding:20px;
            box-shadow:0 3px 12px rgba(0,0,0,0.1);
        }
        
        .preview-card h3{
            color:#1f3f98;
            font-size:32px;
            margin-bottom:10px;
        }
        
        .preview-card p{
            margin-bottom:10px;
        }
        
        .preview-card img{
            width:100%;
            border-radius:10px;
            margin-top:10px;
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

    <div class="search-box">
        <input type="text" placeholder="Search">
        <i class="fas fa-search"></i>
    </div>

    <div class="icons">
    <i class="fas fa-home" onclick="location.href='dashboard.php'" title="Dashboard"></i>
    <i class="far fa-bookmark"></i>
    <i class="far fa-bell"></i>
    <i class="far fa-user-circle" onclick="location.href='profile.php'"></i>
</div>

</header>
    <div class="main-container">
    <div class="form-area">

        <div class="tabs">
            <div class="tab active" onclick="showPage('details',this)">
                <div class="num">1</div> <div class="label">Quiz Details</div>
            </div>
            <div class="tab" onclick="showPage('questions',this)">
                <div class="num">2</div> <div class="label">Questions</div>
            </div>
            <div class="tab" onclick="showPage('settings',this)">
                <div class="num">3</div> <div class="label">Quiz Settings</div>
            </div>
        </div>
        <form method="POST" enctype="multipart/form-data">

            <!-- quiz detail page -->
            <div id="details" class="page show">
                <label>Quiz Title</label>
                <input type="text" name="quiz_title" required>

                <label>Description</label>
                <textarea name="description"></textarea>

                <label>Subject/Category</label>
                <select name="category">
                    <option>Programming</option>
                    <option>Database</option>
                </select>

                <label>Difficulty Level</label>
                <div class="difficulty-inline">
                    <input type="radio" id="easy" name="difficulty" value="Easy">
                    <label for="easy">Easy</label>

                    <input type="radio" id="medium" name="difficulty" value="Medium">
                    <label for="medium">Medium</label>

                    <input type="radio" id="hard" name="difficulty" value="Hard">
                    <label for="hard">Hard</label>
                </div>

                <label>Quiz Cover</label>
                <input type="file" name="cover" accept="image/png, image/jpeg">

                <br><br>
                <button type="submit" name="save_details">Save</button>
            </div>
        </form>

        <!-- question page -->
        <div id="questions" class="page">
            <div id="questionContainer">
                <div class="question-box">
                    <label>Question 1</label>
                    <input type="text" name="question[]" placeholder="Enter your question">

                    <div class="options">
                        <input type="text" name="optionA[]" placeholder="Option A">
                        <input type="text" name="optionB[]" placeholder="Option B">
                        <input type="text" name="optionC[]" placeholder="Option C">
                        <input type="text" name="optionD[]" placeholder="Option D">
                    </div>

                    <div class="q-actions">
                        <button type="button" class="delete-btn" onclick="deleteQuestion(this)">Delete</button>
                    </div>
                </div>
            </div>
            <button type="button" onclick="addQuestion()">+ Add Question</button>
            <button type="button" onclick="saveDraft()">Save Draft</button>
        </div>

        <!-- setting page -->
    <div id="settings" class="page">
         <h2>Quiz Settings</h2>
         <label>Time Limit (minutes)</label>
         <input type="number" name="time_limit" placeholder="Minutes">
         <label>Attempts Allowed</label>
         <input type="number" name="attempts" placeholder="Number of attempts">
         
         <label>Visibility</label>
         <select name="visibility">
            <option value="public">Public – Anyone can access</option>
            <option value="private">Private – Only invited students</option>
        </select>

    <label>Show Results</label>
    <select name="show_results">
        <option value="immediate">Show immediately after submission</option>
        <option value="later">Show later (manual release)</option>
    </select>
    <br><br>
    <button type="button" onclick="publishQuiz()">Publish</button>
</div>
    </div>

    <!-- quiz title preview -->
    <div class="preview-area">
        <div class="preview-card">
            <h2>
                <?php echo $_SESSION['quiz_title'] ?? 'Quiz Title Preview'; ?>
            </h2>
            <p>
                <?php echo $_SESSION['description'] ?? 'Description preview will appear here'; ?>
            </p>
            <p>
                <?php if(isset($_SESSION['category'])) echo "Subject: ".$_SESSION['category']; ?>
            </p>
            <p>
                <?php if(isset($_SESSION['difficulty'])) echo "Difficulty: ".$_SESSION['difficulty']; ?>
            </p>
            <img src="<?php echo $_SESSION['cover'] ?? 'default.png'; ?>" alt="Quiz Cover">
        </div>
    </div>
</div>
</div>
<script src="quiz.js"></script>
</body>
</html>