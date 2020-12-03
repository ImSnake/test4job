<?php

namespace app\models;
use app\models\repositories\TasksRepository;

class Tasks
{
    private $tasksData;
    public $tasksList;
    public $splitTasks;
    public $pageStep = 0;


    public $name;
    public $email;
    public $task;


    public function __construct()
    {
        $this->tasksData = new TasksRepository();
        $this->tasksList = $this->tasksData->getTasks();
        $this->splitTasks = array_chunk( $this->tasksList, 3 , true );
    }

    /**
     * @param $step
     */
    public function getStep($step)
    {
        if ( $step === 'F' ) {
            $this->pageStep += 1;
        } elseif ( $step === 'B' && $this->pageStep > 0) {
            $this->pageStep -= 1;
        } else {
            $this->pageStep = 0;
        }
    }

    public function getNewTask()
    {
        var_dump($_POST);
        var_dump($_POST['email']);
        var_dump($this->email);

        $this->name = $_POST['name'];
        $this->email = $_POST['email'];
        $this->task = $_POST['task'];
    }
/*    private function checkAuthForm()
    {
        $this->name = trim($_POST['form']['name']) ?? '';
        $this->email = trim($_POST['form']['email']) ?? '';
        $this->task = trim($_POST['form']['task']) ?? '';

        // проверяем бала ли заполнена и отправлена форма авторизации.
        if (!empty($this->name) && !empty($this->email) && !empty($this->task)) {
            return true;
        }

        return false;
    }*/
}