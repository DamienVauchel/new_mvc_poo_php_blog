<?php

namespace Controller;

use Entity\Post;
use Framework\Controller\Controller;
use Manager\PostManager;

/**
 * Class DefaultController
 * @package Controller
 */
class DefaultController extends Controller
{
    /**
     * @var PostManager
     */
    private $manager;

    /**
     * DefaultController constructor.
     */
    public function __construct()
    {
        $this->manager = new PostManager();
    }

    /**
     * @throws \Framework\Exception\ManagerException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function indexAction()
    {
        $datas = $this->manager->findAll('posts');

        $posts = [];
        foreach ($datas as $data) {
            $posts[] = new Post($data);
        }

        return $this->render('public/default/home.html.twig', array(
            'posts' => $posts
            ));
    }
}