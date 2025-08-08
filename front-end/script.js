const addbtn = document.getElementById("add-task");
const editbtn = document.getElementById("edit-task");
const deletebtn = document.getElementById("delete-task");
const task = document.getElementById("task")
const taskPre = document.querySelector(".tasks-view");
const error = document.getElementById("error");
const allTasks = document.querySelectorAll(".task");
const selectAllBtn = document.getElementById("select-all");

const themeToggle = document.getElementById("theme-toggle");

updateSelectAllButton();
addCheckboxListeners();

function addTask(){
    let taskText = task.value;
    if (taskText.trim() ==="")
        {error.textContent = "Task cannot be empty!";
        return;
        }
        else{
            error.textContent = "";     
    const tasks_div = document.createElement("div");
    tasks_div.classList.add("task");
    const checkbox = document.createElement("input");
    checkbox.type = "checkbox";
    const span = document.createElement("span");
    checkbox.classList.add("task-checkbox");
    span.classList.add("task-text");
    span.textContent = taskText;
    tasks_div.appendChild(checkbox);
    tasks_div.appendChild(span);
    taskPre.appendChild(tasks_div);
    task.value ="";
        }
updateSelectAllButton();
addCheckboxListeners();
}

function editTask() {
    const allTasks = document.querySelectorAll(".task");
    const newText = task.value.trim();

    if (newText === "") {
        error.textContent = "Please enter a new task to edit!";
        return;
    }

    let selectedTasks = [];

    for (let taskItem of allTasks) {
        const checkbox = taskItem.querySelector("input");
        if (checkbox.checked) {
            selectedTasks.push(taskItem);
        }
    }

    if (selectedTasks.length === 0) {
        error.textContent = "Please select a task to edit!";
    } else if (selectedTasks.length > 1) {
        error.textContent = "Please select only one task to edit!";
    } else {
        const taskItem = selectedTasks[0];
        const span = taskItem.querySelector("span");
        const checkbox = taskItem.querySelector("input");

        span.textContent = newText;
        checkbox.checked = false;

        error.textContent = "";
        task.value = "";
    }
}

function deleteTask() {
    const allTasks = document.querySelectorAll(".task");
    let found = false;

    allTasks.forEach(taskItem => {
        const checkbox = taskItem.querySelector("input");
        if (checkbox.checked) {
            taskPre.removeChild(taskItem);
            found = true;
        }
    });

    if (found) {
        error.textContent = "";
    } else {
        error.textContent = "Please select at least one task to delete!";
    }
}

themeToggle.addEventListener("click", () => {
    document.body.classList.toggle("dark-mode");
    if (document.body.classList.contains("dark-mode")) {
        themeToggle.textContent = "☀️ Light Mode";
    } else {
        themeToggle.textContent = "🌙 Dark Mode";
    }
});

function selectALL(){
const allCheckboxes = document.querySelectorAll(".task input[type='checkbox']");
const allSelected = Array.from(allCheckboxes).every(cb => cb.checked);
allCheckboxes.forEach(cb => cb.checked = !allSelected);

updateSelectAllButton();

};
function updateSelectAllButton() {
    const allCheckboxes = document.querySelectorAll(".task input[type='checkbox']");
    const selectAllBtn = document.getElementById("select-all");

    if (allCheckboxes.length === 0) {
        selectAllBtn.textContent = "Select All";
        selectAllBtn.disabled = true;
        return;
    }
    const allSelected = Array.from(allCheckboxes).every(cb => cb.checked);
    selectAllBtn.textContent = allSelected ? "Unselect All" : "Select All";
    selectAllBtn.disabled = false;
}
function addCheckboxListeners() {
    const allCheckboxes = document.querySelectorAll(".task input[type='checkbox']");
    allCheckboxes.forEach(cb => {
        cb.removeEventListener('change', updateSelectAllButton); // prevent duplicate
        cb.addEventListener('change', updateSelectAllButton);
    });
}

selectAllBtn.addEventListener("click", selectALL);
addbtn.addEventListener("click", addTask);
editbtn.addEventListener("click", editTask);
deletebtn.addEventListener("click", deleteTask);