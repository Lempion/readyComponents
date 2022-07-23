<?php

namespace App\controllers;

use App\exception\IdEqualToFiveException;
use App\exception\YourIdNotMatchException;
use App\QueryBuilder;
use Exception;
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

    public function post($data)
    {
        $db = new QueryBuilder();
        $post = $db->getOne($data, 'posts');

        try {
            $this->getMoney($data['id']);
        } catch (YourIdNotMatchException $exception) {
            flash()->error('Ваш айди не подходит!');
        }catch (IdEqualToFiveException $exception){
            flash()->error('Айди не может быть равен 5!');
        }


        echo $this->templates->render('post', ['message' => 'Ваш пост', 'post' => $post]);
    }

    function getMoney($value)
    {
        $idAccept = 5;

        if ($value > $idAccept) {
            throw new YourIdNotMatchException("Your id doesn't match");
        }

        if ($value == 5){
            throw new IdEqualToFiveException("Id cannot be equal to 5");
        }
    }

}