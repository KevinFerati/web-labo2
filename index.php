<?php
require_once('lib/template.php');
require_once('lib/persistence.php');
$repo = new TaskRepository();
$tasks = $repo->getAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://unpkg.com/htmx.org@1.9.9" integrity="sha384-QFjmbokDn2DjBjq+fM+8LUIVrAgqcNW2s0PjAxHETgRn9l4fvX31ZxDxvwQnyMOX" crossorigin="anonymous"></script>

    <title>HTML 5 Boilerplate</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main>
        <h1>Yet Another Todo-list App</h1>
        <div id="message"></div>
        <section id="tasks">
            <h2>Vos tâches</h2>
            <?php
                foreach ($tasks as $task) {
                    render($task);
                }
            ?>
        </section>

        <section>
            <h2>Ajouter une tâche</h2>
            <form hx-target="#tasks" hx-swap="beforeend" hx-post="/tasks.php">
                    <div class='form-group'>
                        <label for='description'>Description</label>
                        <textarea name='description'></textarea>
                    </div>
                    <div class='form-group'>
                        <label for='status'>Status</label>
                        <select name='status'>
                            <option value='Done'>Terminé</option>
                            <option value='InProgress'>En cours</option>
                            <option value='ToDo'>À faire</option>
                        </select>
                    </div>
                    <input type='submit' value='Ajouter' />
            </form>
        </section>

    </main>
</body>
</html>