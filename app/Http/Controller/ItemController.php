<?php

namespace App\Http\Controller;

/**
 * Class HomeController
 * @package App\Http\Controller
 */
class ItemController extends Controller
{

    /**
     * @return false|string
     */
    public function index()
    {
        $this->setTitle('index');

        return $this->render('user.index');
    }

    /**
     * @param $id
     * @return false|string
     */
    public function show($id)
    {
        $this->setTitle('show');

        return $this->render('user.show');
    }

    /**
     * @return false|string
     */
    public function create()
    {
        $this->setTitle('create');

        return $this->render('user.create');
    }

    /**
     * store
     */
    public function store()
    {
        $this->back();
    }

    /**
     * @param $id
     * @return false|string
     */
    public function edit($id)
    {
        $this->setTitle('edit');

        return $this->render('user.edit');
    }

    /**
     * @param $id
     * @return false|string
     */
    public function update($id)
    {
        $this->back();
    }

    /**
     * @param $id
     * @return false|string
     */
    public function delete($id)
    {
        return $this->render('delete');
    }

}