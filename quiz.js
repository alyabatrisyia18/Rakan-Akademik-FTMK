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
    let questions = [];

    document.querySelectorAll(".question-box").forEach(box => {
        questions.push({
            question: box.querySelector('input[name="question[]"]').value,
            A: box.querySelectorAll('input[name="optionA[]"]')[0].value,
            B: box.querySelectorAll('input[name="optionB[]"]')[0].value,
            C: box.querySelectorAll('input[name="optionC[]"]')[0].value,
            D: box.querySelectorAll('input[name="optionD[]"]')[0].value
        });
    });

    fetch("save_questions.php", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify(questions)
    }).then(() => {
        alert("Draft saved!");
    });
}