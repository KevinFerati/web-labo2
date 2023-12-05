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
    <article hx-include="this" hx-validate='true' hx-trigger='change, input delay:500ms, keyup changed delay:500ms' hx-patch='/tasks.php'>
        <div class='form-group'>
            <label for='description'>Description</label>
            <textarea name='description' required>{$task->description}</textarea>
        </div>
        <div class='form-group'>
            <label for='status'>Status</label>
            <select name='status'>
                {$option($task->status, TaskStatus::Done, "Terminé")}
                {$option($task->status, TaskStatus::InProgress, "En cours")}
                {$option($task->status, TaskStatus::ToDo, "À faire")}
            </select>
        </div>
    EOT;
    renderDates($task->beginDate, $task->dueDate);
    echo<<<EOT
    
    <button type="button" class="btn btn-danger" hx-indicator="closest article" hx-include="next input[type='hidden']" hx-delete="/tasks.php" hx-target="closest article" hx-swap="outerHTML" >Supprimer</button>
    <input type='hidden' name='id' value='{$task->id}' />
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


function renderDates(?string $dateBegin, ?string $dueDate) {
    $valueDateBegin = $dateBegin !== null ? "value='{$dateBegin}'" : "";
    $valueDueDate = $dueDate !== null ? "value='{$dueDate}'" : "";
    echo <<<EOT
    <div class="form-group">
        <label for="beginDate">Début</label>
        <input name="beginDate" type="date" max="$dueDate"  $valueDateBegin />
    </div>
    <div class="form-group">
        <label for="dueDate">Échéance</label>
        <input name="dueDate" type="date" min="$dateBegin" $valueDueDate />
    </div>
EOT;
}