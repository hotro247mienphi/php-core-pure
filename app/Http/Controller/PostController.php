<?php

namespace App\Http\Controller;

use App\Service\HomeService;

/**
 * Class HomeController
 * @package App\Http\Controller
 */
class PostController extends Controller
{

    /**
     * @param string $catId
     * @param array $postId
     * @return false|mixed|string
     */
    public function view($catId, $postId)
    {
        $this->setTitle('Post - View');

        return $this->render('post.view', []);
    }
}