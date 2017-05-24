<?php

class Task
{

    protected $host = 'localhost';
    protected $dbname = 'ershov';
    protected $dbuser = 'ershov';
    protected $dbpassword = 'neto1048';

    public function addTask()
    {

        $description = (string)(isset($_POST['task']) ? $_POST['task'] : "");
        if (empty($description) || strlen($description) < 3) {
            return false;
        }

        try {
            $pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->dbuser, $this->dbpassword, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            die('Произошла ошибка, не удалось установить соединение с базой');
        }

        $query = "INSERT INTO tasks (description, date_added) VALUE (?, NULL)";
        $statement = $pdo->prepare($query);

        try {
            $statement->execute([$description]);
        } catch (PDOException $e) {
            die('Произошла ошибка, не удалось выполнить запрос');
        }

        return true;
    }

    public function getAllTasks()
    {
        try {
            $pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->dbuser, $this->dbpassword, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            die('Произошла ошибка, не удалось установить соединение с базой');
        }

        $query = "SELECT * FROM tasks";
        $statement = $pdo->prepare($query);

        try {
            $statement->execute();
        } catch (PDOException $e) {
            die('Произошла ошибка, не удалось выполнить запрос');
        }

        return $statement;
    }

    public function setTaskIsDone()
    {
        try {
            $pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->dbuser, $this->dbpassword, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            die('Произошла ошибка, не удалось установить соединение с базой');
        }

        $id = (int)!empty($_POST['id']) ? $_POST['id'] : 0;

        $query = "UPDATE tasks SET is_done = 1 WHERE id = ?";
        $statement = $pdo->prepare($query);

        try {
            $statement->execute([$id]);
        } catch (PDOException $e) {
            die('Произошла ошибка, не удалось выполнить запрос');
        }
    }

    public function deleteTask()
    {
        try {
            $pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->dbuser, $this->dbpassword, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            die('Произошла ошибка, не удалось установить соединение с базой');
        }

        $id = (int)!empty($_POST['id']) ? $_POST['id'] : 0;

        $query = "DELETE FROM tasks WHERE id = ?";
        $statement = $pdo->prepare($query);

        try {
            $statement->execute([$id]);
        } catch (PDOException $e) {
            die('Произошла ошибка, не удалось выполнить запрос');
        }
    }

    public function editTask()
    {
        try {
            $pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->dbuser, $this->dbpassword, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            die('Произошла ошибка, не удалось установить соединение с базой');
        }

        $description = (string)!empty($_POST['editDescription']) ? $_POST['editDescription'] : 0;
        $id = (int)!empty($_POST['id']) ? $_POST['id'] : 0;

        $query = "UPDATE tasks SET description = ? WHERE id = ?";
        $statement = $pdo->prepare($query);

        try {
            $statement->execute([$description, $id]);
        } catch (PDOException $e) {
            die('Произошла ошибка, не удалось выполнить запрос');
        }
    }

}