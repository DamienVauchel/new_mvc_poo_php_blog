<?php

namespace Controller;

use Entity\Post;
use Framework\Controller\Controller;
use Manager\PostManager;

class DefaultController extends Controller
{
    private $manager;

    public function __construct()
    {
        $this->manager = new PostManager();
    }

    public function indexAction()
    {
        $datas = $this->manager->findAll('posts');

        $posts = [];
        foreach ($datas as $data) {
            $posts[] = new Post($data);
        }

        return $this->render('public/default/home.html.twig', array('posts' => $posts));
    }
}