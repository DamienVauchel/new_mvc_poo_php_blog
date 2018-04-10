<?php

namespace Controller;

use Entity\Post;
use Framework\Controller\Controller;
use Framework\Exception\LoginException;
use Framework\Session\FlashMessage;
use Framework\Session\Session;
use Manager\PostManager;

/**
 * Class PostController
 * @package Controller
 */
class PostController extends Controller
{
    /**
     * @var PostManager
     */
    private $postManager;

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->postManager = new PostManager();
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @throws LoginException
     */
    public function addAction()
    {
        $datas = $_POST;

        if (!empty($datas)) {
            $checkedDatas = $this->checkDatas($datas);

            $title = $checkedDatas['title'];
            $content = $checkedDatas['content'];
            $author = $checkedDatas['author'];
            $slug = $this->slugify($title);

            $this->postManager->add($title, $content, $author, $slug);

            $this->redirectTo('home');
        }

        $this->roles = $this->getLoggedUserRoles();

        $this->render('public/post/create.html.twig', array('roles' => $this->roles));
    }

    /**
     * @param $slug
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @throws LoginException
     */
    public function viewAction($slug)
    {
        if (isset($_SESSION['loggedUser']) && !empty($_SESSION['loggedUser'])) {
            $this->roles = $this->getLoggedUserRoles();
        }

        $post = $this->postManager->findOneBySlug($slug);

        return $this->render('public/post/view.html.twig', array(
            'post' => $post,
            'roles' => $this->roles
        ));
    }

    /**
     * @throws \Framework\Exception\ManagerException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @throws LoginException
     */
    public function viewAllAction()
    {
        if (isset($_SESSION['loggedUser']) && !empty($_SESSION['loggedUser'])) {
            $this->roles = $this->getLoggedUserRoles();
        }

        $datas = $this->postManager->findAll('posts');

        $posts = [];
        foreach ($datas as $data) {
            $posts[] = new Post($data);
        }

        return $this->render('public/post/view_all.html.twig', array(
            'posts' => $posts,
            'roles' => $this->roles
        ));
    }
}