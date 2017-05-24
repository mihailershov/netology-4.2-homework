<?php

require_once 'controller.php';

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style/index.css">
    <title>Task manager</title>
</head>
<body>
<div id="wrapper">
    <div class="tasks">

        <?php if ($allTasks->rowCount() === 0): ?>
            <p class="smile">&#9785;</p>
            <p>Вы пока не добавили ни одной зачади</p>
        <?php else: ?>
            <table>
                <tr>
                    <td>Задача</td>
                    <td>Статус</td>
                    <td>Дата добавления</td>
                    <td>Действия</td>
                </tr>
                <?php foreach ($allTasks as $task): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($task['description']) ?></td>
                        <td><?php echo htmlspecialchars($task['is_done']) ? '<p style="color: green">Выполнено</p>' : '<p style="color: orange">В процессе</p>' ?></td>
                        <td><?php echo htmlspecialchars($task['date_added']) ?></td>
                        <td>
                            <p class='edit link'>Изменить &#9998;</p>
                            <form method="POST">
                                <input type="submit" name="done" value="Выполнить &#10004;" class="link">
                                <input type="submit" name="delete" value="Удалить &cross;" class="link">
                                <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>

    </div>

    <div class="forms">
        <form method="POST" class="addTaskForm">
            <?php if (!empty($_SESSION['notice'])): ?>
                <p class="notice"><?php echo $_SESSION['notice']; ?> &#10004;</p>
                <?php unset($_SESSION['notice']) ?>
            <?php endif; ?>
            <textarea name="task" placeholder="Задача" id="task" cols="50" rows="3" required></textarea>
            <input type="submit" name="addTask" value="Добавить задачу" class="button">
        </form>
        <!--        <form method="POST">
                    <label>
                        Сортировать по:
                        <select name="sortBy" id="sortBy">
                            <option value="date">Дате добавления</option>
                            <option value="status">Статусу</option>
                            <option value="description">Описанию</option>
                        </select>
                    </label>
                    <input type="submit" name="sort" id="sort" value="Сортировка">
                </form>-->
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="js/index.js"></script>

</body>
</html>
