<?php

namespace Controller;

use Entity\Comment;
use Entity\Post;
use Framework\Controller\Controller;
use Framework\Exception\LoginException;
use Framework\Pagination\Pagination;
use Framework\Session\FlashMessage;
use Framework\Session\Session;
use Manager\CommentManager;
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
    private $commentManager;

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->postManager = new PostManager();
        $this->commentManager = new CommentManager();
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

        if (isset($_SESSION['token']) && !empty($_SESSION['token'])) {
            $this->token = $_SESSION['token'];
        }

        if (!empty($datas)) {
            $checkedDatas = $this->checkDatas($datas);

            if ($_SESSION['token'] == $checkedDatas['token']) {
                $title = $checkedDatas['title'];
                $content = $checkedDatas['content'];
                $author = $this->getLoggedUserUsername();
                $slug = $this->slugify($title);

                $this->postManager->add($title, $content, $author, $slug);
            }

            $this->redirectTo('home');
        }

        $this->roles = $this->getLoggedUserRoles();

        $this->render('public/post/create.html.twig', array(
            'roles' => $this->roles,
            'token' => $this->token
            ));
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

        if (isset($_SESSION['token']) && !empty($_SESSION['token'])) {
            $this->token = $_SESSION['token'];
        }

        $datas = $this->postManager->findOneBySlug($slug);
        $post = new Post($datas);

        $postId = $post->getId();
        $dbDatas = $this->commentManager->findAllByPost($postId);
        $comments = [];
        foreach ($dbDatas as $data) {
            $comments[] = new Comment($data);
        }

        $postedDatas = $_POST;

        if (!empty($postedDatas)) {
            $checkedDatas = $this->checkDatas($postedDatas);

            if ($_SESSION['token'] == $checkedDatas['token']) {
                $comment = $checkedDatas['comment'];
                $author = $this->getLoggedUserUsername();

                if (empty($comment)) {
                    return header('Location: http://'.ROOT.'/post/'.$slug);
                }

                $this->commentManager->add($comment, $author, $postId);
            }

            header('Location: http://'.ROOT.'/post/'.$slug);
        }

        return $this->render('public/post/view.html.twig', array(
            'post' => $post,
            'comments' => $comments,
            'roles' => $this->roles,
            'token' => $this->token
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

        $pagination = new Pagination($posts, 3);
        $paginatedDatas = $pagination->pagine($posts);
        $posts = $paginatedDatas['datas'];
        $navigation = $paginatedDatas['navigation'];

        return $this->render('public/post/view_all.html.twig', array(
            'posts' => $posts,
            'pagination' => $pagination,
            "navigation" => $navigation,
            'roles' => $this->roles
        ));
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function editAction()
    {
        $get = explode('/', $_GET['url']);
        $get = $this->checkDatas($get);
        $slug = $get[2];

        $dbDatas = $this->postManager->findOneBySlug($slug);
        $post = new Post($dbDatas);

        $datas = $_POST;

        if (isset($_SESSION['token']) && !empty($_SESSION['token'])) {
            $this->token = $_SESSION['token'];
        }

        if (!empty($datas)) {
            $checkedDatas = $this->checkDatas($datas);

            if ($_SESSION['token'] == $checkedDatas['token']) {
                $title = $checkedDatas['title'];
                $content = $checkedDatas['content'];
                $slug = $this->slugify($title);

                $this->postManager->update($title, $content, $slug);
            }

            $this->redirectTo('home');
        }

        $this->render('public/post/edit.html.twig', array(
            'post' => $post,
            'token' => $this->token
        ));
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function deleteAction()
    {
        $get = explode('/', $_GET['url']);
        $get = $this->checkDatas($get);
        $slug = $get[2];

        if (isset($_SESSION['token']) && !empty($_SESSION['token'])) {
            $this->token = $_SESSION['token'];
        }

        $dbDatas = $this->postManager->findOneBySlug($slug);
        $post = new Post($dbDatas);

        if (isset($_POST['deleteSubmit'])) {
            if ($_SESSION['token'] == $_POST['token']) {
                $this->postManager->delete($slug);
            }

            $this->redirectTo('admin');
        }

        $this->render('public/post/delete.html.twig', array(
            'post' => $post,
            'token' => $this->token
        ));
    }
}