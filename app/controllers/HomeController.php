<?php

namespace App\controllers;

use JasonGrimes\Paginator;
use League\Plates\Engine;
use App\QueryBuilder;
use Delight\Auth\Auth;
use App\Mailer;
use Exception;
use PDO;


class HomeController
{
    private $templates, $auth, $queryBuilder;

    public function __construct(QueryBuilder $qb, Engine $engine, Auth $auth)
    {
        $this->queryBuilder = $qb;
        $this->templates = $engine;
        $this->auth = $auth;
    }

    public function index()
    {
        $postsPerPage = 4;
        $currentPage = ($_GET['page'] ?: 1);
        $urlPattern = '/?page=(:num)';

        $posts = $this->queryBuilder->getWithLimit('posts', $postsPerPage, $currentPage);
        $totalPosts = count($this->queryBuilder->getAll('posts'));

        $paginator = new Paginator($totalPosts, $postsPerPage, $currentPage, $urlPattern);

        echo $this->templates->render('home', ['message' => 'Домашняя страница', 'posts' => $posts, 'auth' => $this->auth, 'paginator' => $paginator]);
    }

    public function post($data)
    {
        $post = $this->queryBuilder->getOne($data, 'posts');
        echo $this->templates->render('post', ['message' => 'Ваш пост', 'post' => $post]);
    }

    public function registration()
    {
        echo $this->templates->render('registration', ['message' => 'Регистрация']);
    }

    public function regForm()
    {
        try {
            $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['username'], function ($selector, $token) {

                Mailer::sendRegisterDataVerification(['selector' => $selector, 'token' => $token], $_POST['email'], $_POST['username']);

                echo 'Check your mail for verification account.';

            });

            echo 'We have signed up a new user with the ID ' . $userId;
        } catch (\Delight\Auth\InvalidEmailException $e) {
            die('Invalid email address');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password');
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('User already exists');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }


    }

    public function login()
    {
        echo $this->templates->render('login', ['message' => 'Авторизация']);
    }

    public function logForm()
    {
        try {
            $this->auth->login($_POST['email'], $_POST['password']);

            echo 'User is logged in';
        } catch (\Delight\Auth\InvalidEmailException $e) {
            die('Wrong email address');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Wrong password');
        } catch (\Delight\Auth\EmailNotVerifiedException $e) {
            die('Email not verified');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function verificationEmail()
    {
        try {
            $this->auth->confirmEmail($_GET['selector'], $_GET['token']);
//            $this->auth->confirmEmail($_GET['selector'], $_GET['token']);

            echo 'Email address has been verified';
        } catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        } catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function roles()
    {
        $users = $this->queryBuilder->getAll('users', ['id', 'email', 'username', 'roles_mask']);

        echo $this->templates->render('roles', ['message' => 'Edit roles', 'arrUsers' => $users]);
    }

    public function editRole()
    {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $this->auth->admin()->addRoleForUserById($_POST['id'], $_POST['idRole']);
        }
    }


}