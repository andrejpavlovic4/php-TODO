<?php

namespace App\Models;

use PDO;
use \Core\View;


class TodoLists extends \Core\Model {

    /**
     * Get Task for the specific TODO list
     */
    public static function getTasks($id)
    {
        $sql = 'SELECT * FROM tasks
                WHERE todo_list_id = :id';
                
        $db = static::getDB();    
        
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create new task for specific TODO list
     */
    public static function newTask($id) {

        $sql = 'INSERT INTO tasks (todo_list_id, title, priority, deadline, state)
                VALUES (:todo_list_id, :title, :priority, :deadline, :state)';

        
        $db = static::getDB();    

        $stmt = $db->prepare($sql);
        
        $stmt->bindValue(':todo_list_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
        $stmt->bindValue(':priority', $_POST['priority'], PDO::PARAM_STR);
        $stmt->bindValue(':deadline', $_POST['date'], PDO::PARAM_STR);
        $stmt->bindValue(':state', $_POST['state'], PDO::PARAM_BOOL);
    
        return $stmt->execute();

    }

    /**
     * Delete task from database 
     */
    public static function deleteTask($id) {

        $sql = 'DELETE FROM  tasks WHERE id = :id';

        $db = static::getDB();    

        $stmt = $db->prepare($sql);
        
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Get the task by his ID
     */
    public static function getTaskById($id) {

        $sql = 'SELECT * FROM tasks WHERE id=:id';

        $db = static::getDB();    

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Editing task information and updating the database
     */
    public static function editTask($id, $title, $priority, $deadline, $status) {

        $sql = 'UPDATE tasks SET title=:title, priority=:priority, deadline=:deadline, state=:status
                WHERE id=:id';

        $db = static::getDB();    

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':priority', $priority, PDO::PARAM_STR);
        $stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);
        $stmt->bindValue(':status', $status, PDO::PARAM_BOOL);

        return $stmt->execute();
    }

    /**
     * Counting all tasks from a TODO list
     */
    public static function countAllTasks($id) {

        $sql = 'SELECT COUNT(*) FROM tasks, todo_lists
                WHERE tasks.todo_list_id = todo_lists.id
                  AND task.id=:id';

        $db = static::getDB();    

        $stmt = $db->prepare($sql);

        $stmt->execute();

        $numberOfColumns = $stmt->fetchColumn();

        return $numberOfColumns;

    }
}

?>