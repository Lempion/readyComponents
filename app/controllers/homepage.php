<?php

use App\QueryBuilder;

$db = new QueryBuilder();

$posts = $db->getAll('posts');

echo '<pre>';
var_dump($posts);
echo '</pre>';

echo '-----';

//$db->insert(['title'=>'New title from QueryFactory'],'posts');
//$db->update(['title' => 'TITLE2'],'posts',2);
$db->delete(5, 'posts');
echo '-----';

$posts = $db->getAll('posts');

echo '<pre>';
var_dump($posts);
echo '</pre>';
