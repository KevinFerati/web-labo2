<?php
require_once('task.php');

class TaskRepository {
    private Pdo $pdo;
    
    public function __construct() {
        $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=tasks', 'mariadb', 'mariadb');
    }

    public function create(Task $task): Task {
            return new Task(0, "", TaskStatus::Done);
    }

    /**
     * @return Task[]
     */
    public function getAll(): array {
        return array(new Task(0, "", TaskStatus::Done));
    }

}



