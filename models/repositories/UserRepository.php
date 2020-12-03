<?php
/**
 * Created by PhpStorm.
 * User: pulik
 * Date: 26.10.2018
 * Time: 17:22
 */

namespace app\models\repositories;

use app\models\User;

class UserRepository extends Repository
{

    public function getTableName()
    {
        return 'users';
    }

    public function getEntityClass()
    {
        return User::class;
    }



    public function getUserByRole()
    {

    }

    public function getUserCart()
    {

    }

    public function getUserOrders()
    {

    }

}