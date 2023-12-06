<?php 
require_once('task.php');
/**
 * Affiche une tâche modifiable au complet
 */
function render(Task $task) {   
    echo <<<EOT
    <article hx-include="this" 
             hx-validate='true'
             hx-swap="outerHTML" 
             hx-trigger='change, input delay:500ms, keyup changed delay:500ms' 
             hx-patch='/tasks.php'
             class="bg-light"
             >
        
    EOT;
        renderMain($task->description, $task->status);
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

/**
 * Affiche les champs de description et le status
 */
function renderMain(string $description, TaskStatus $status) {
    
    $option = function (TaskStatus $current, TaskStatus $status, string $name) {
        $selected = $status == $current ? "selected='selected'" : "";
        return <<<EOT
        <option value='$status->value' $selected>$name</option>
    EOT;
    };
    echo <<<EOT
    <div class='mb-3'>
        <label class="col-3 col-form-label"  for='description'>Description</label>
        <textarea class="form-control" name='description' required>{$description}</textarea>
    </div>
    <div class='row mb-3'>
        <label class="col-3 col-form-label" for='status'>Status</label>
        <div class="col">
            <select class="form-control" name='status'>
                {$option($status, TaskStatus::Done, "Terminé")}
                {$option($status, TaskStatus::InProgress, "En cours")}
                {$option($status, TaskStatus::ToDo, "À faire")}
            </select>
        </div>
    </div>
EOT;
}

/**
 * Affiche les champs de date
 */
function renderDates(?string $dateBegin, ?string $dueDate) {
    $valueDateBegin = $dateBegin !== null ? "value='{$dateBegin}'" : "";
    $valueDueDate = $dueDate !== null ? "value='{$dueDate}'" : "";
    $classesControl = "class='form-control'"; 
    $labelClasses = "class='col-3 col-form-label'";
    echo <<<EOT
        <div class="row mb-3">
            <label $labelClasses for="beginDate">Début</label>
            <div class="col">
                <input $classesControl name="beginDate" placeholder="Début" type="date" max="$dueDate"  $valueDateBegin />
            </div>
            </div>
        <div class="row mb-3">
            <label $labelClasses for="dueDate">Échéance</label>
            <div class="col">
                <input $classesControl name="dueDate" placeholder="Échéance" type="date" min="$dateBegin" $valueDueDate />
            </div>
        </div>
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
