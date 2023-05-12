# ToDo List Backend Project
This project is a todo list API that allows creating, retrieving, updating, and deleting tasks.
It is developed in PHP for the backend, while the frontend part is in another repository here => { https://github.com/YohannHERBET/todolist-front }

## Features
- Creation of tasks with a date, name, and description
- Recovery all tasks
- Modification of existing tasks
- Deletion of tasks
- Notification of tasks scheduled for today

## Prerequisites
- PHP 7.4 or higher
- Composer
- Web server (ex: Apache, Nginx)
- MySQL 5.7 or higher

## Installation
- Clone this repository to the directory of your choice.
- Navigate to the project folder and install the dependencies using the command `composer install`.
- A script is already prepared to create the database. You just need to modify the informations in the config.ini file located at the root of the project.
- When your informations is done, launch the script `php install/createDB.php` for have the BDD and the table
- Launch the php server with `php -S localhost:8000 -t public`
