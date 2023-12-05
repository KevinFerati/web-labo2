<?php
require_once('task.php');

class TaskRepository
{
    private readonly PDO $pdo;
    private PDOStatement $insertStmt;
    private PDOStatement $deleteStmt;
    private PDOStatement $updateStmt;
    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=tasks', 'mariadb', 'mariadb');
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->insertStmt = $this->pdo->prepare("INSERT INTO tasks (description, dueDate, beginDate, status) VALUES(:description, :dueDate, :beginDate, :status)");
        $this->deleteStmt = $this->pdo->prepare("DELETE FROM tasks WHERE id = :id");
        $this->updateStmt = $this->pdo->prepare("UPDATE tasks SET description = :description, status = :status, dueDate = :dueDate, beginDate = :beginDate WHERE id = :id");
    }

    public function update(Task $task)
    {
        $this->bindModifiyingStmt($this->updateStmt, $task);
        $this->updateStmt->bindValue(":id", $task->id, PDO::PARAM_INT);
        $this->updateStmt->execute();
    }

    public function delete(int $id)
    {
        $this->deleteStmt->bindValue(":id", $id, PDO::PARAM_INT);
        $this->deleteStmt->execute();
    }

    public function create(Task $task): Task
    {
        $this->bindModifiyingStmt($this->insertStmt, $task);
        $this->insertStmt->execute();

        $lastId = $this->pdo->lastInsertId();
        return new Task($lastId, $task->description, $task->dueDate, $task->beginDate, $task->status->value);
    }

    private function bindModifiyingStmt(PDOStatement $stmt, Task $task)
    {
        
        $stmt->bindValue(":description", $task->description, PDO::PARAM_STR);
        $stmt->bindValue(":status", $task->status->value, PDO::PARAM_STR);
        $stmt->bindValue(":dueDate", $task->dueDate == "" ? null : $task->dueDate, PDO::PARAM_STR);
        $stmt->bindValue(":beginDate", $task->beginDate == "" ? null : $task->beginDate, PDO::PARAM_STR);
    }

    /**
     * @return Task[]
     */
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT id, description, dueDate, beginDate, status FROM tasks");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn ($row): Task => new Task(...$row), $rows);
    }
}
