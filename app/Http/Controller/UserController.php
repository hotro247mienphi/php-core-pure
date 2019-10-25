<?php

namespace App\Http\Controller;

use App\Core\Layout;
use App\Service\UserService;

/**
 * Class HomeController
 * @package App\Http\Controller
 */
class UserController extends Controller
{
    protected $service;

    public function __construct(Layout $layout)
    {
        parent::__construct($layout);
        $this->service = new UserService();
    }

    /**
     * @return false|string
     */
    public function create()
    {
        $this->setTitle('Create User');
        return $this->render('user.create');
    }

    /**
     * @param $id
     * @return false|string
     */
    public function show($id)
    {
        $this->setTitle('Show User');
        $data = $this->service->showAction($id);
        return $this->json($data);
    }

    /**
     * store
     */
    public function store()
    {
        $this->setTitle('Info page');
        $this->service->createAction();
        $this->back();
    }

    /**
     * @param $id
     * @return false|string
     */
    public function edit($id)
    {
        $this->setTitle('Edit User');
        $shared = $this->service->editAction($id);
        return $this->render('user.edit', $shared);
    }

    /**
     * @param $id
     */
    public function update($id)
    {
        $this->service->updateAction($id);
        $this->back();
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->service->updateAction($id);
        $this->back();
    }

}