<?php

namespace Controller;

use Entity\Post;
use Framework\Controller\Controller;
use Framework\Exception\LoginException;
use Framework\Mailer\Mailer;
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
        $dbDatas = $this->manager->findFourLast();
        $datas = $_POST;

        $posts = [];
        foreach ($dbDatas as $data) {
            $posts[] = new Post($data);
        }

        if (isset($_SESSION['loggedUser']) && !empty($_SESSION['loggedUser'])) {
            $this->roles = $this->getLoggedUserRoles();
        }

        if (!empty($datas)) {
            $checkedDatas = $this->checkDatas($datas);

            $firstname = $checkedDatas['firstname'];
            $lastname = $checkedDatas['lastname'];
            $email = $checkedDatas['email'];
            $subject = $checkedDatas['subject'];
            $message = $checkedDatas['message'];

            $mailer = new Mailer();
            $mailer->sendMail($lastname, $firstname, $email, $subject, $message);

            $this->redirectTo('home');
        }

        return $this->render('public/default/home.html.twig', array(
            'posts' => $posts,
            'roles' => $this->roles
            ));
    }
}