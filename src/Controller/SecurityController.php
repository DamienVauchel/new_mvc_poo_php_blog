<?php

namespace Controller;

use Framework\Controller\Controller;
use Manager\UserManager;

class SecurityController extends Controller
{
    private $securityManager;

    public function __construct()
    {
        $this->securityManager = new UserManager();
    }

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

    public function loginAction()
    {
        $datas = $_POST;

        if (!empty($datas) && isset($datas)) {

        }

        $this->render('public/security/login.html.twig');
    }
}