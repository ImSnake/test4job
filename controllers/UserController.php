<?php

namespace app\controllers;

use app\models\User;
use app\models\repositories\UserRepository;

class UserController extends Controller
{
    public function actionAccount()
    {
        echo $this->defineRenderer("pages/user", [],  ['title' => 'My Account']);
    }

    // пример сохранения
    /**
    public function addItem()
    {
        $entity = new User();
        $entity->login = 'anna';
        $entity->password = 'qwery1234';
        (new UserRepository())->save($entity);
    }
     * */

//login/account
}