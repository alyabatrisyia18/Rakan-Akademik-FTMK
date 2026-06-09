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