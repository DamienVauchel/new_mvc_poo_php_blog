<?php

namespace Controller;

use Framework\Controller\Controller;
use Manager\PostManager;

/**
 * Class AdminController
 * @package Controller
 */
class AdminController extends Controller
{
    /**
     * @var PostManager
     */
    private $postManager;

    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->postManager = new PostManager();
    }

    /**
     * @throws \Framework\Exception\ManagerException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function indexaction()
    {
        $posts = $this->postManager->findAll('posts');

        return $this->render('admin/default/panel.html.twig', array(
            'posts'     => $posts
        ));
    }
}