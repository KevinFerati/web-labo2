<?php
require_once('lib/persistence.php');
require_once('lib/template.php');

// Try creating a new task
function handlePost() {
    
    $description = $_POST['description'];
    $status = $_POST['status'];
    $task = new Task(0, $description, $status);

    $repo = new TaskRepository(); 
    try {
        $newTask = $repo->create($task);
        render($newTask);
        renderStatusMessage("La tâche a été correctement créée", MessageStatus::Success);
    } catch (Exception $e) {
        http_response_code(500);
        renderStatusMessage("Erreur à la création de la tâche : " . $e->getMessage(), MessageStatus::Error);
    }
}

// Try updating the task
function handlePatch() {

}

function handleDelete() {
    parse_str(file_get_contents("php://input"), $body);
    $id = $body['id'];
    $repo = new TaskRepository();
    try {
        $repo->delete($id);
        renderStatusMessage("La tâche a été correctement supprimée", MessageStatus::Success);
    } catch (Exception $e) {
        http_response_code(500);
        renderStatusMessage("Erreur à la création de la tâche : " . $e->getMessage(), MessageStatus::Error);
    }
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        handlePost();
        break;
    case 'PATCH':
        break;
    case 'DELETE':
        handleDelete();
        break;
}