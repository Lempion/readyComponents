<?php

namespace App\controllers;

use App\QueryBuilder;
use League\Plates\Engine;

class HomeController
{
    private $templates;

    public function __construct()
    {
        $this->templates = new Engine('../app/views/');
    }

    public function index()
    {
        echo $this->templates->render('home', ['message' => 'Домашняя страница']);
    }

    public function post($id)
    {
        $db = new QueryBuilder();
        $post = $db->getOne($id, 'posts');

        echo $this->templates->render('post', ['message' => 'Ваш пост', 'post' => $post]);
    }

}