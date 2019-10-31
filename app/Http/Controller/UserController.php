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

    /**
     * UserController constructor.
     * @param Layout $layout
     */
    public function __construct(Layout $layout)
    {
        parent::__construct($layout);
        $this->service = new UserService();
    }

    /**
     * @return false|string
     */
    public function index()
    {
        $this->setTitle('List Users');
        $shared = $this->service->indexAction();
        return $this->render('user.index', $shared);
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
     * @return false|string
     */
    public function create()
    {
        $this->setTitle('Create User');
        $shared = $this->service->createAction();
        return $this->render('user.create', $shared);
    }

    /**
     * store
     */
    public function store()
    {
        $this->service->storeAction();
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
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->service->deleteAction($id);
        $this->redirect(route('users.index'));
    }

}