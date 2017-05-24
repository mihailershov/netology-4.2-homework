<?php

session_start();

require_once 'Task.php';
$task = new Task;

$allTasks = $task->getAllTasks();

if (!empty($_POST['addTask'])) {
    $notice = $task->addTask() ? 'Задача успешна добавлена' : 'Что-то пошло не так, попробуйте еще раз';
    $_SESSION['notice'] = $notice;
    header('Location: ' . $_SERVER['REQUEST_URI']);
    die;
}

if (!empty($_POST['done'])) {
    $task->setTaskIsDone();
    header('Location: ' . $_SERVER['REQUEST_URI']);
}

if (!empty($_POST['delete'])) {
    $task->deleteTask();
    header('Location: ' . $_SERVER['REQUEST_URI']);
}

if (!empty($_POST['editDescription'])) {
    $task->editTask();
    header('Location: ' . $_SERVER['REQUEST_URI']);
}