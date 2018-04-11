<?php

namespace Controller;

use Entity\Post;
use Framework\Controller\Controller;
use Framework\Exception\LoginException;
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
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @throws LoginException
     */
    public function indexAction()
    {
        $datas = $this->manager->findFourLast();

        $posts = [];
        foreach ($datas as $data) {
            $posts[] = new Post($data);
        }

        if (isset($_SESSION['loggedUser']) && !empty($_SESSION['loggedUser'])) {
            $this->roles = $this->getLoggedUserRoles();
        }

        return $this->render('public/default/home.html.twig', array(
            'posts' => $posts,
            'roles' => $this->roles
            ));
    }
}