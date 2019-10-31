<?php


namespace App\Service;

use App\Core\Mysql;
use App\Core\QueryBuilder;
use App\Core\Request;
use App\Core\Session;

class UserService
{
    /**
     * @return array
     */
    public function indexAction()
    {
        $builder = new QueryBuilder();

        $builder->from('users')
            ->select(['id', 'name', 'email', 'status', 'created_at'])
            ->where('id', '>', 10)
            ->andWhere('id', '<', 100)
            ->andWhere('status', 1)
            ->order('created_at', 'desc')
            ->limit(200);

        $data = Mysql::selectAll($builder->generate(), ...$builder->getBindParams());

        return [
            'data' => $data,
        ];
    }

    /**
     * createAction
     */
    public function createAction()
    {
        $user = [
            'name' => '',
            'email' => '',
            'password' => '',
        ];

        return ['user' => (object)$user];
    }

    /**
     * storeAction
     */
    public function storeAction()
    {
        $data = Request::all();

        $errors = [];
        if (empty(arr_get($data, 'name'))) {
            $errors[] = 'name can not blank.';
        }

        if (empty(arr_get($data, 'email'))) {
            $errors[] = 'email can not blank.';
        }

        if (empty(arr_get($data, 'password'))) {
            $errors[] = 'password can not blank.';
        }

        if ($errors) {
            Session::set('validate_error', $errors);
            redirect(Request::referer());
        }

        Mysql::insert('users', $data);

    }


    /**
     * @param $id
     * @return array
     */
    public function showAction($id)
    {
        $user = Mysql::findById('users', $id);

        return ['user' => $user];
    }

    /**
     * @param $id
     * @return array
     */
    public function editAction($id)
    {
        $user = Mysql::findById('users', $id);

        return ['user' => $user];
    }

    /**
     * @param $id
     */
    public function updateAction($id)
    {
        $user = Mysql::findById('users', $id);
        $data = Request::all();

        if ($user && $data) {
            Mysql::update('users', $data, ['id' => $id]);
        }
    }

    /**
     * @param $id
     */
    public function deleteAction($id)
    {
        Mysql::delete('users', ['id' => $id]);
    }
}