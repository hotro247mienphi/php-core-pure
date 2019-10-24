<?php


namespace App\Service\Api;

use App\Core\Mysql;
use App\Core\Request;

class UserService
{
    public function dataIndexAction()
    {
        $sql = "SELECT `id`, `name`, `email`, `status`, `created_at` FROM `users` LIMIT 10";
        $data = Mysql::selectAll($sql);
        return [
            'data' => $data,
        ];
    }

    public function createAction()
    {
        $request = new Request();
        $data = $request->all();
        Mysql::insert('users', $data);
    }

    public function editAction($id)
    {

        $user = Mysql::findById('users', $id);
        return [
            'user'=>$user
        ];
    }

    public function updateAction($id)
    {

        $user = Mysql::findById('users', $id);

        if ($user) {
            $request = new Request();
            $data = $request->all();

            Mysql::update('users', $data, ['id' => $id]);
        }
    }
}