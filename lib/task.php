<?php 
/**
 * Représente les états possibles d'une tâche. Les valeurs sont celles de l'ENUM de la DB
 */
enum TaskStatus: String {
    case ToDo = 'ToDo';
    case Done = 'Done';
    case InProgress = 'InProgress';    
}

class Task {
    public readonly TaskStatus $status;

    public function __construct(
        public readonly int $id, 
        public readonly string $description,
        public readonly ?string $dueDate,
        public readonly ?string $beginDate,
        string $status) {
        $this->status = TaskStatus::from($status);
    }
}

