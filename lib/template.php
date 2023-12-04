<?php 
require_once('task.php');

function render(Task $task) {

    $option = function (TaskStatus $current, TaskStatus $status, string $name) {
        $selected = $status == $current ? "selected='selected'" : "";
        return <<<EOT
        <option value='$status->value' $selected>$name</option>
    EOT;
    };

    echo <<<EOT
    <article hx-include="this" hx-trigger='change, keyup delay:500ms' hx-patch='/tasks.php'>
        <div class='form-group'>
            <label for='description'>Description</label>
            <textarea name='description'>{$task->getDescription()}</textarea>
        </div>
        <div class='form-group'>
            <label for='status'>Status</label>
            <select name='status'>
                {$option($task->getStatus(), TaskStatus::Done, "Terminé")}
                {$option($task->getStatus(), TaskStatus::InProgress, "En cours")}
                {$option($task->getStatus(), TaskStatus::ToDo, "À faire")}
            </select>
        </div>
        <button type="button" class="btn btn-danger" hx-indicator="closest article" hx-include="next input[type='hidden']" hx-delete="/tasks.php" hx-target="closest article" hx-swap="outerHTML" >Supprimer</button>
        <input type='hidden' name='id' value='{$task->getId()}' />
        
        <img class="htmx-indicator" src="https://htmx.org/img/bars.svg"/>
    </article>
    EOT;
}

enum MessageStatus: String {
    case Success = "success";
    case Error = "danger";
}

function renderStatusMessage(string $message, MessageStatus $status) {
    echo <<<EOT
    <div id="message" hx-swap-oob="true" class="alert alert-{$status->value}">$message</div>
EOT;
}