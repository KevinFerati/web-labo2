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
    <script type="application/javascript">
        // enable swap behavior on 400
        htmx.on("htmx:beforeSwap", (e) => {
            if (e.detail.xhr.status == 400) {
                e.detail.shouldSwap = true;
            }
        });
    </script>
    <style>
        #tasks {
            display: grid;
            grid-gap: 2rem;
            grid-template-columns: repeat(auto-fill, minmax(20rem, 1fr));
            grid-auto-rows: 1fr;
            & > *:first-child {
                grid-row: 1 / 1;
                grid-column: 1 / 1;
            }

            &::before {
                content: '';
            width: 0;
            padding-bottom: 100%;
            grid-row: 1 / 1;
            grid-column: 1 / 1;
            }
        }

        article {
            border: 1px solid lightgrey;
            padding: 0.6rem;
        }

    </style>
</head>

<body>
    <main class="container">
        <h1>Yet Another Todo-list App</h1>
        <div id="message"></div>
        <section class="row">
            <!-- List of tasks -->
            <section class="col-8">
                <h2>Vos tâches</h2>
                <div id="tasks">
                    <?php
                    foreach ($tasks as $task) {
                        render($task);
                    }
                    ?>
                </div>

            </section>
            
            <!-- form to add the tasks -->
            <section class="col-4 border-start">
                <h2>Ajouter une tâche</h2>
                <form hx-target="#tasks" hx-swap="beforeend" hx-indicator="#form-indicator" hx-post="/tasks.php">
                <?php 
                    renderMain("", TaskStatus::Done);
                    renderDates(null, null);
                    ?>
                    <input class="col-9 btn btn-primary " type='submit' value='Ajouter' />
                    <img id="form-indicator" class="offset-1 col-1 htmx-indicator" src="https://htmx.org/img/bars.svg"/>
                </form>
            </section>

        </section>
    </main>
</body>

</html>