<?php

namespace Controller;

use Entity\Post;
use Framework\Controller\Controller;
use Framework\Session\FlashMessage;
use Framework\Session\Session;
use Manager\PostManager;

class PostController extends Controller
{
    private $postManager;

    public function __construct()
    {
        $this->postManager = new PostManager();
    }

    public function addAction($datas)
    {
        if (!empty($datas)) {
            $checkedDatas = $this->checkDatas($datas);

            $title = $checkedDatas['title'];
            $content = $checkedDatas['content'];
            $author = $checkedDatas['author'];
            $slug = $this->slugify($title);

            $this->postManager->add($title, $content, $author, $slug);

            $this->redirectTo('home');
        }

        $this->render('public/post/create.html.twig');
    }

    public function viewAction($slug)
    {
        $post = $this->postManager->findOneBySlug($slug);

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