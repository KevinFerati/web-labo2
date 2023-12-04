<?php
require_once('lib/persistence.php');
require_once('lib/template.php');
// Try creating a new task
function handlePost() {
    
    $description = $_POST['description'];
    $status = $_POST['status'];
    $task = new Task(0, $description, $status);
    
    $repo = new TaskRepository();
    $newTask = $repo->create($task);
    render($newTask);

}

// Try updating the task
function handlePatch() {

}

function handleDelete() {

}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        handlePost();
        break;
    case 'PATCH':
        break;
    case 'DELETE':
        break;
}