<?php

namespace Controller;

use Entity\Post;
use Framework\Controller\Controller;
use Manager\PostManager;

class PostController extends Controller
{
    private $postManager;

    public function __construct()
    {
        $this->postManager = new PostManager();
    }

    public function viewAction($id)
    {
        $post = $this->postManager->findOneById($id);

        return $this->render('public/post/view.html.twig', array('post' => $post));
    }

    public function viewAllAction()
    {
        $datas = $this->postManager->findAll('posts');

        $posts = [];
        foreach ($datas as $data) {
            $posts[] = new Post($data);
        }

        return $this->render('public/post/view_all.html.twig', array('posts' => $posts));
    }
}