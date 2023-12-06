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

// On post, try creating a task from the body
function handlePost() {
    
    $repo = new TaskRepository(); 
    try {
        
        $task = tryGetTask($_POST);
        if (gettype($task) === "string") {
            writeError($task);
            return;
        }

        $newTask = $repo->create($task);
        render($newTask);
        renderStatusMessage("La tâche a été correctement créée", MessageStatus::Success);
    } catch (Exception $e) {
        http_response_code(500);
        renderStatusMessage("Erreur à la création de la tâche : " . $e->getMessage(), MessageStatus::Error);
    }
}   

// On delete, try delete the task with the ID given in the body
function handleDelete() {
    parse_str(file_get_contents("php://input"), $body);
    try {
        $id = $body['id'];
        if (is_nan($id)) {
            writeError();
            return;
        }
        $repo = new TaskRepository();
        $repo->delete($id);
        renderStatusMessage("La tâche a été correctement supprimée", MessageStatus::Success);
    } catch (Exception $e) {
        http_response_code(500);
        renderStatusMessage("Erreur à la création de la tâche : " . $e->getMessage(), MessageStatus::Error);
    }
}

// On patch, try updating the task that has the given ID
function handlePatch() {
    parse_str(file_get_contents("php://input"), $body);
    try {
        $task = tryGetTask($body);
        if (getType($task) == "string" || is_nan($body["id"]))  {
            writeError($task);
            return;
        }
        $repo = new TaskRepository();
        $repo->update($task);
        render($task);
        renderStatusMessage("La tâche a été correctement modifiée", MessageStatus::Success);
    } catch (Exception $e) {
        http_response_code(500);
        renderStatusMessage("Erreur à la création de la tâche : " . $e->getMessage(), MessageStatus::Error);
    }
}

/**
 * Try to create a task from the body and returns null if it's not possible due to a bad request
 */
function tryGetTask(array $body): Task|string {

    $keys = ["description", "status"];
    foreach ($keys as $key) {
        if (!array_key_exists($key, $body)) {
            return "Informations manquantes : " . $key;
        }
    }

    $desc = $body['description'];
    $status = $body['status'];
    $dueDate = $body["dueDate"];
    $beginDate = $body["beginDate"];
    if (!isValid($desc) || !isValid($status)) {
        return "Données invalides";
    }

    if (isset($dueDate) && isset($beginDate) && $beginDate > $dueDate) {
        return "La date de début ne peut pas être plus grande que la date de fin";
    }

    // check if the status is a valid TaskStatus
    if (TaskStatus::tryFrom($status) === null) {
        return "mauvais type de statut";
    }

    return new Task($body['id'] ?? 0, $desc, $dueDate, $beginDate, $status);
}


function isValidDate(string $date) {
    return !isset($date) ? true :  strtotime($date) !== false;
}

function isValid(string $str) {
    return isset($str) && strlen($str) > 0;
}

function writeError(string $message = "Entrées incorrectes") {
    header('HX-Retarget: #message');
    http_response_code(400);
    renderStatusMessage($message, MessageStatus::Error);
}
