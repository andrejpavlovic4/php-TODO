<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Models\TodoLists;
use DateTime;


class TodoList extends \Core\Controller
{

    public $task = array();

    /**
     * TodoList index
     */
    public function indexAction()
    {
        $todo_lists =  User::getTodoLists($_SESSION['user_id']);

        $task = array();

        foreach($todo_lists as $list) {
            array_push($task, TodoLists::getTasks($list["id"]));
        }

        $task = array_reduce($task, 'array_merge', array());

        View::renderTemplate('todolist/index.html', [
            'todo_lists' => $todo_lists,
            'task' => $task,
        ]);
    }

    /**
     * Controller method for creating new TODO list through passing the ID to the Model
     */
    public function newAction() {

        View::renderTemplate('todolist/new.html');
        
        if($_POST) {
           User::newTodoList($_SESSION['user_id']);
           header('Location: http://' . $_SERVER['HTTP_HOST'] . '/todolist/index');
        }
    }

    /**
     * Controller method for deleting a TODO list
     */
    public function deleteListAction() {
        if(isset($_POST)) {
           User::deleteList($_SESSION['user_id'], $_POST["id"]);
           header('Location: http://' . $_SERVER['HTTP_HOST'] . '/todolist/index');
        }
    }

    /**
     * Controller method for creating a new task in a specific list
     */
    public function newTaskAction() {

        if(isset($_POST)) {
            TodoLists::newTask($_POST["id"]);
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/todolist/index');
        }
    }

    /**
     * Get the value for TODO list ID through query params
     */
    public function getIdAction() {
        $id = $this->route_params["id"];
        View::renderTemplate('TodoList/newtask.html', [
            'id' => $id
        ]);
    }

    /**
     * Get the value for task ID through query params
     */
    public function taskIdAction() {
        $id = $this->route_params["id"];
        $data = TodoLists::getTaskById($id);
        foreach($data as &$item) {
            $item["deadline"] = substr_replace($item["deadline"] , "T", 10, 0);
            $item["deadline"]= str_replace(' ', '', $item["deadline"]);
        }
        View::renderTemplate('TodoList/edittask.html', [
            "data" => $data,
            'id' => $id
        ]);
    }

    /**
     * Controller method for deleting specific task
     */
    public function deleteTaskAction() {
        if(isset($_POST)) {
            TodoLists::deleteTask($_POST["id"]);
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/todolist/index');
        }
    }

    /**
     * Controller method for editing existing task
     */
    public function editTaskAction() {
            $_POST["date"]= str_replace('T', ' ', $_POST["date"]);
            TodoLists::editTask($_POST["id"], $_POST["title"], $_POST["priority"], $_POST["date"], $_POST["state"]);
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/todolist/index');

    }
}