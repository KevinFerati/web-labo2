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
    <article hx-trigger='change delay:500ms, keyup delay:500ms' hx-patch='/tasks.php'>
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
        <input type='hidden' name='id' value='{$task->getId()}' />
    </article>
    EOT;
}