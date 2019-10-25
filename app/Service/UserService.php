<?php


namespace App\Service;

use App\Core\Mysql;
use App\Core\Request;

class UserService
{
    public function dataIndexAction()
    {
        $sql = "SELECT `id`, `name`, `email`, `status`, `created_at` FROM `users`";

        $data = Mysql::selectAll($sql);

        return ['data' => $data];
    }

    public function createAction()
    {
        $data = Request::all();
        Mysql::insert('users', $data);
    }

    public function showAction($id)
    {
        $user = Mysql::findById('users', $id);

        return ['user' => $user];
    }

    public function editAction($id)
    {

        $user = Mysql::findById('users', $id);

        return ['user' => $user];
    }

    public function updateAction($id)
    {

        $user = Mysql::findById('users', $id);
        $data = Request::all();

        if ($user && $data) {

            Mysql::update('users', $data, ['id' => $id]);
        }
    }

    public function deleteAction($id)
    {

        $user = Mysql::findById('users', $id);

        if ($user) {
            Mysql::delete('users', ['id' => $id]);
        }
    }
}