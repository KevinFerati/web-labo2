<?php 
enum TaskStatus: String {
    case ToDo = 'ToDo';
    case Done = 'Done';
    case InProgress = 'InProgress';    
}

class Task {
    private TaskStatus $status;

    public function __construct(
        private int $id, 
        private string $description, 
        string $status) {
        $this->status = TaskStatus::from($status);
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getStatus(): TaskStatus {
        return $this->status;
    }

    public function getId(): int {
        return $this->id;
    }

}

