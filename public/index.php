<?php

require '../vendor/autoload.php';

if ($_SERVER['REQUEST_URI'] == '/'){
    require '../app/controllers/homepage.php';
}


