# Yet another Todolist app
- Auteur : Kevin Ferati

Cette application permet de faire du jamais vu : d'organiser vos tâches simplement en y mettant des decriptions, des dates de début et d'échance ainsi qu'un statut.

Ce site a été fait avec PHP 8.2. La base de données est MariaDB v10.4.

# Lancement
La webapp a été développée en utilisant devcontainer. Pour l'utiliser, il faut ouvrir le projet avec VSCode, `ctrl + shift + p` et `Open folder in container`. Ensuite, depuis le terminal, lancer la commande `php -S localhost:8080`.

Au lancement, le schéma de la DB est créée automatiquement avec quelques données par défaut. Le fichier se site dans : .devcontainer/schema.sql
# Structure

La structure est la suivante : 

- dossier `lib`
	- `persistence.php` : contient une classe interfaçant le site avec la DB
	- `task.php` : contient le modèle de la table `tasks`
	- `template.php` : contient des fichiers de rendu HTML
- `tasks.php` : c'est le fichier dans lequel les requêtes POST, PATCH et DELETE seront traitées
- `index.php` : point d'entrée principale du site

