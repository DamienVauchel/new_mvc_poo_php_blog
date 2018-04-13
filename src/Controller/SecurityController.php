<?php

namespace Controller;

use Entity\User;
use Framework\Controller\Controller;
use Framework\Exception\LoginException;
use Framework\Security\Ticket;
use Framework\Session\Session;
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
        if (isset($_SESSION['loggedUser'])) {
            return $this->render('public/default/home.html.twig');
        }

        $datas = $_POST;

        if (!empty($datas) && isset($datas)) {
            $checkedDatas = $this->checkDatas($datas);

            $username = $checkedDatas['username'];
            $email = $checkedDatas['email'];
            $password = $checkedDatas['password'];
            $hashedPw = $this->encryptPw($password);

            $this->securityManager->add($username, $email, $hashedPw);

            $this->redirectTo('login');
        }

        $this->render('public/security/signup.html.twig');
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @throws LoginException
     */
    public function loginAction()
    {
        $datas = $_POST;

        if (!empty($datas) && isset($datas)) {
            $checkedDatas = $this->checkDatas($datas);

            $dbDatas = $this->securityManager->findOneByUsername('"'.$datas['username'].'"');
            $user = new User($dbDatas);

            $hashedPw = $user->getHashedPw();

            if ($this->decryptPw($checkedDatas['password'], $hashedPw))
            {
                $serializedUser = serialize($user);
                $session = new Session();
                $session->set('loggedUser', $serializedUser);

                $this->redirectTo('home');
            } else {
                throw new LoginException("Merci de taper le bon mot de passe");
            }
        }

        $this->render('public/security/login.html.twig');
    }

    /**
     * Logout action
     */
    public function logoutAction()
    {
        unset($_SESSION);
        session_destroy();

        $this->redirectTo('home');
    }
}