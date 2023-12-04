<?php 
enum TaskStatus: String {
    case ToDo = 'ToDo';
    case Done = 'Done';
    case InProgress = 'InProgress';    
}

class Task {
    private int $id;
    private string $description;
    private TaskStatus $status;

    public function __construct(int $id, string $description, TaskStatus $status) {
        $this->description = $description;
        $this->status = $status;
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

