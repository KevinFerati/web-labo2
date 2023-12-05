CREATE TABLE tasks.tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255) NOT NULL,
    dueDate DATE NULL,
    beginDate DATE NULL,
    status ENUM('ToDo', 'Done', 'InProgress') NOT NULL
);

INSERT INTO tasks.tasks (description, dueDate, beginDate, status) VALUES
    ('Faire les courses', '2023-12-10', '2023-12-05', 'ToDo'),
    ('Répondre aux e-mails', '2023-12-08', '2023-12-01', 'InProgress'),
    ('Terminer le rapport', '2023-12-15', '2023-12-03', 'ToDo'),
    ('Préparer la réunion', '2023-12-05', '2023-11-30', 'Done'),
    ('Exercice quotidien', '2023-12-07', '2023-12-01', 'InProgress'),
    ('Rédiger le code source', '2023-12-12', '2023-12-05', 'ToDo'),
    ('Présenter le projet', '2023-11-30', '2023-11-28', 'Done');

