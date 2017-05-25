<?php

require_once 'core.php';

if (!empty($_POST['addTask'])) {
    $task->addTask();
    echo $task->getLastTask();
}

if (!empty($_POST['done'])) {
    $status = $task->setTaskIsDone() ? 'Выполнено' : 'В процессе';
    echo $status;
}

if (!empty($_POST['delete'])) {
    $task->deleteTask();
}

if (!empty($_POST['editDescription'])) {
    echo $task->editTask();
}