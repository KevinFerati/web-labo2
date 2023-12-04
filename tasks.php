<?php
require_once('lib/persistence.php');
require_once('lib/template.php');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        handlePost();
        break;
    case 'PATCH':
        handlePatch();
        break;
    case 'DELETE':
        handleDelete();
        break;
}

// Try creating a new task
function handlePost() {
    
    $repo = new TaskRepository(); 
    try {
        
    $description = $_POST['description'];
    $status = $_POST['status'];
    $task = new Task(0, $description, $status);

        $newTask = $repo->create($task);
        render($newTask);
        renderStatusMessage("La tâche a été correctement créée", MessageStatus::Success);
    } catch (Exception $e) {
        http_response_code(500);
        renderStatusMessage("Erreur à la création de la tâche : " . $e->getMessage(), MessageStatus::Error);
    }
}


function handleDelete() {
    parse_str(file_get_contents("php://input"), $body);
    try {
        $id = $body['id'];
        $repo = new TaskRepository();
        $repo->delete($id);
        renderStatusMessage("La tâche a été correctement supprimée", MessageStatus::Success);
    } catch (Exception $e) {
        http_response_code(500);
        renderStatusMessage("Erreur à la création de la tâche : " . $e->getMessage(), MessageStatus::Error);
    }
}

function handlePatch() {
    parse_str(file_get_contents("php://input"), $body);
    try {
        $id = $body['id'];
        $description = $body['description'];
        $status = $body['status'];
        $taskToUpdate = new Task($id, $description, $status);
        $repo = new TaskRepository();
        $repo->update($taskToUpdate);
        render($taskToUpdate);
        renderStatusMessage("La tâche a été correctement modifiée", MessageStatus::Success);
    } catch (Exception $e) {
        http_response_code(500);
        renderStatusMessage("Erreur à la création de la tâche : " . $e->getMessage(), MessageStatus::Error);
    }
}
