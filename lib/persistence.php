<?php
require_once('task.php');

class TaskRepository {
    private PDO $pdo;
    private PDOStatement $insertStmt;
    private PDOStatement $deleteStmt;
    private PDOStatement $updateStmt;
    public function __construct() {
        $this->pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=tasks', 'mariadb', 'mariadb');
        $this->insertStmt = $this->pdo->prepare("INSERT INTO tasks (description, status) VALUES(:description, :status)");
        $this->deleteStmt = $this->pdo->prepare("DELETE FROM tasks WHERE id = :id");
        $this->updateStmt = $this->pdo->prepare("UPDATE tasks SET description = :description, status = :status WHERE id = :id");
    }

    public function update(Task $task) {
        $this->updateStmt->bindValue(":description", $task->getDescription(), PDO::PARAM_STR);
        $this->updateStmt->bindValue(":status", $task->getStatus()->value, PDO::PARAM_STR);
        $this->updateStmt->bindValue(":id", $task->getId(), PDO::PARAM_INT);
        $this->updateStmt->execute();   
    }

    public function delete(int $id) {
        $this->deleteStmt->bindValue(":id", $id, PDO::PARAM_INT);
        $this->deleteStmt->execute();
    }

    public function create(Task $task): Task {
            $this->insertStmt->bindValue(":description", $task->getDescription(), PDO::PARAM_STR);
            $this->insertStmt->bindValue(":status", $task->getStatus()->value, PDO::PARAM_STR);
            $this->insertStmt->execute();
            $lastId = $this->pdo->lastInsertId();
            return new Task($lastId, $task->getDescription(), $task->getStatus()->value);
    }

    /**
     * @return Task[]
     */
    public function getAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM tasks");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row): Task => new Task(...$row), $rows);
    }
}



