<?php

namespace Controller;

use Framework\Controller\Controller;
use Manager\UserManager;

/**
 * Class SecurityController
 * @package Controller
 */
class SecurityController extends Controller
{
    /**
     * @var UserManager
     */
    private $securityManager;

    /**
     * SecurityController constructor.
     */
    public function __construct()
    {
        $this->securityManager = new UserManager();
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function signUpAction()
    {
        $datas = $_POST;

        if (!empty($datas) && isset($datas)) {
            $checkedDatas = $this->checkDatas($datas);

            $username = $checkedDatas['username'];
            $email = $checkedDatas['email'];
            $password = $checkedDatas['password'];

            $ok = $this->securityManager->add($username, $email, $password);

//            die(var_dump($ok));

            $this->redirectTo('login');
        }

        $this->render('public/security/signup.html.twig');
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function loginAction()
    {
        $datas = $_POST;

        if (!empty($datas) && isset($datas)) {

        }

        $this->render('public/security/login.html.twig');
    }
}