<?php

namespace App\controllers;

use App\QueryBuilder;
use Exception;
use League\Plates\Engine;
use PDO;

class HomeController
{
    private $templates, $auth;

    public function __construct()
    {
        $db = new PDO('mysql:host=localhost;dbname=app2', 'root', '');

        $this->auth = new \Delight\Auth\Auth($db);
        $this->templates = new Engine('../app/views/');
    }

    public function index()
    {
        $db = new QueryBuilder();
        $posts = $db->getAll('posts');

        echo $this->templates->render('home', ['message' => 'Домашняя страница', 'posts' => $posts,'auth' => $this->auth]);
    }

    public function post($data)
    {
        $db = new QueryBuilder();
        $post = $db->getOne($data, 'posts');
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
                echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
                echo '  For emails, consider using the mail(...) function, Symfony Mailer, Swiftmailer, PHPMailer, etc.';
                echo '  For SMS, consider using a third-party service and a compatible SDK';
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
        echo $this->templates->render('login',['message' => 'Авторизация']);
    }

    public function logForm()
    {
        try {
            $this->auth->login($_POST['email'], $_POST['password']);

            echo 'User is logged in';
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            die('Wrong email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Wrong password');
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            die('Email not verified');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function verificationEmail()
    {
        try {
            $this->auth->confirmEmail('cGc5oSpOIFdNCNgG', 'jtX56d8ym5mxGkUJ');
//            $this->auth->confirmEmail($_GET['selector'], $_GET['token']);

            echo 'Email address has been verified';
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }


}