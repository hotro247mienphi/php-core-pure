<?php

namespace App\Http\Controller;

use App\Service\Api\UserService;

/**
 * Class HomeController
 * @package App\Http\Controller
 */
class UserController extends Controller
{

    /**
     * @return false|string
     */
    public function create()
    {
        $this->setTitle('Create User');

        return $this->render('user.create');
    }

    /**
     * store
     */
    public function store()
    {
        $this->setTitle('Info page');

        $userService = new UserService();

        $userService->createAction();

        $this->back();
    }

    /**
     * @param $id
     * @return false|string
     */
    public function edit($id)
    {
        $this->setTitle('Edit User');

        $userService = new UserService();

        $shared = $userService->editAction($id);

        return $this->render('user.edit', $shared);
    }

    /**
     * @param $id
     */
    public function update($id)
    {

        $userService = new UserService();

        $userService->updateAction($id);

        $this->back();
    }

}