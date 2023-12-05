<?php 
require_once('task.php');
function labelClasses(): string {
    return "class='col-form-label'";
}

function controlClasses(): string {
    return "class='form-control'";
}

function render(Task $task) {   

    $option = function (TaskStatus $current, TaskStatus $status, string $name) {
        $selected = $status == $current ? "selected='selected'" : "";
        return <<<EOT
        <option value='$status->value' $selected>$name</option>
    EOT;
    };
    $classesControl = controlClasses();
    $classes = labelClasses();
    echo <<<EOT
    <article hx-include="this" hx-validate='true' hx-swap="outerHTML" hx-trigger='change, input delay:500ms, keyup changed delay:500ms' hx-patch='/tasks.php'>
        <div class='form-group'>
            <label $classes  for='description'>Description</label>
            <textarea $classesControl name='description' required>{$task->description}</textarea>
        </div>
        <div class='form-group'>
            <label $classes for='status'>Status</label>
            <select $classesControl name='status'>
                {$option($task->status, TaskStatus::Done, "Terminé")}
                {$option($task->status, TaskStatus::InProgress, "En cours")}
                {$option($task->status, TaskStatus::ToDo, "À faire")}
            </select>
        </div>
    EOT;
    renderDates($task->beginDate, $task->dueDate);
    echo<<<EOT
    <div>
        <button type="button" class="col-9 btn btn-danger" hx-indicator="closest article" hx-include="next input[type='hidden']" hx-delete="/tasks.php" hx-target="closest article" hx-swap="outerHTML" >Supprimer</button>
        <img class="offset-1 col-1 htmx-indicator" src="https://htmx.org/img/bars.svg"/>

    </div>
    
    <input type='hidden' name='id' value='{$task->id}' />
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
    $classes = labelClasses();
    $classesControl = "class='form-control'"; //controlClasses();
    echo <<<EOT
    <div class="form-row">
        <div class="col">
            <label for="beginDate">Début</label>
            <input $classesControl name="beginDate" placeholder="Début" type="date" max="$dueDate"  $valueDateBegin />
        </div>
        <div class="col">
            <label for="dueDate">Échéance</label>
            <input $classesControl name="dueDate" placeholder="Échéance" type="date" min="$dateBegin" $valueDueDate />
        </div>
    </div>
EOT;
}