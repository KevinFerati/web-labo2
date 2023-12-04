CREATE TABLE tasks.tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255) NOT NULL,
    status ENUM('ToDo', 'Done', 'InProgress') NOT NULL
);

-- Insertion d'exemples de tâches
INSERT INTO tasks.tasks (description, status) VALUES
    ('Faire les courses', 'ToDo'),
    ('Répondre aux e-mails', 'InProgress'),
    ('Terminer le rapport', 'ToDo'),
    ('Préparer la réunion', 'Done'),
    ('Exercice quotidien', 'InProgress'),
    ('Rédiger le code source', 'ToDo'),
    ('Présenter le projet', 'Done');
