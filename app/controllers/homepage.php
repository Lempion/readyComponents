<?php

use App\QueryBuilder;

$db = new QueryBuilder();

$posts = $db->getAll('posts');


// Create new Plates instance
$templates = new League\Plates\Engine('../app/views/');

// Render a template
echo $templates->render('home', ['message' => 'Что то написал']);
