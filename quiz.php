<?php
session_start();

if(isset($_POST['save_details']))
{
    $_SESSION['quiz_title'] = $_POST['quiz_title'];
    $_SESSION['description'] = $_POST['description'];
    $_SESSION['category'] = $_POST['category'];
    $_SESSION['difficulty'] = $_POST['difficulty'];

    // HANDLE COVER IMAGE
    if(isset($_FILES['cover']) && $_FILES['cover']['error'] == 0)
    {
        $imgName = time() . "_" . $_FILES['cover']['name'];
        $target = "uploads/" . $imgName;

        // create folder if not exist
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
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
</head>
<body>

<div class="container">

    <div class="form-area">

        <div class="tabs">
            <div class="tab active" onclick="showPage('details',this)">
                <span class="num">1</span> <span class="label">Quiz Details</span>
            </div>
            <div class="tab" onclick="showPage('questions',this)">
                <span class="num">2</span> <span class="label">Questions</span>
            </div>
            <div class="tab" onclick="showPage('settings',this)">
                <span class="num">3</span> <span class="label">Quiz Settings</span>
            </div>
        </div>

        <form method="POST" enctype="multipart/form-data">

            <!-- PAGE 1 -->
            <div id="details" class="page show">
                <label>Quiz Title</label>
                <input type="text" name="quiz_title" required>

                <label>Description</label>
                <textarea name="description"></textarea>

                <label>Subject/Category</label>
                <select name="category">
                    <option>Programming</option>
                    <option>Database</option>
                    <option>Networking</option>
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

        <!-- PAGE 2 -->
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

        <!-- PAGE 3 -->
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
    <button type="submit" name="save_settings">Publish</button>
</div>
    </div>

    <!-- PREVIEW -->
    <div class="preview-area">
        <div class="preview-card">

            <h3>
                <?php echo $_SESSION['quiz_title'] ?? 'Quiz Title Preview'; ?>
            </h3>

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

<script>

function showPage(pageName, element){
    document.querySelectorAll('.page').forEach(p=>p.classList.remove('show'));
    document.getElementById(pageName).classList.add('show');

    document.querySelectorAll('.tab').forEach(t=>t.classList.remove('active'));
    element.classList.add('active');
}

// ADD QUESTION
function addQuestion(){
    let container=document.getElementById("questionContainer");

    let count=document.querySelectorAll(".question-box").length+1;

    let box=document.createElement("div");
    box.className="question-box";

    box.innerHTML=`
        <label>Question ${count}</label>
        <input type="text" name="question[]">

        <div class="options">
            <input type="text" name="optionA[]">
            <input type="text" name="optionB[]">
            <input type="text" name="optionC[]">
            <input type="text" name="optionD[]">
        </div>

        <div class="q-actions">
            <button type="button" class="delete-btn" onclick="deleteQuestion(this)">Delete</button>
        </div>
    `;

    container.appendChild(box);
}

// DELETE QUESTION
function deleteQuestion(btn){
    btn.closest(".question-box").remove();
}

function saveDraft(){
    let confirmSave = confirm("Save draft?");

    if(confirmSave){
        // pergi ke settings tab
        document.querySelectorAll('.page').forEach(p => p.classList.remove('show'));
        document.getElementById('settings').classList.add('show');

        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab')[2].classList.add('active');
    }
}

</script>

</body>
</html>