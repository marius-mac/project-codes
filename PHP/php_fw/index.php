<?php

/*
$name = $_GET['name'];

printf('Hello %s', $name);
*/

//  if the name query parameter is not defined in the URL query string, you will get a PHP warning; so let's fix it:

/*
$name = isset($_GET['name']) ? $_GET['name'] : 'World';

printf('Hello %s', $name);
*/

// security issue, XSS (Cross-Site Scripting). Here is a more secure version:

/*
$name = isset($_GET['name']) ? $_GET['name'] : 'World';

header('Content-Type: text/html; charset=utf-8');

printf('Hello %s', htmlspecialchars($name, ENT_QUOTES, 'UTF-8'));
*/


// composer require symfony/http-foundation --- sukuria ir vendor/autoload.php

require_once __DIR__.'/init.php'; // require_once __DIR__.'/vendor/autoload.php';

/* 
use Symfony\Component\HttpFoundation\Request; // panaudojam sukurta vedor/autoload.php
use Symfony\Component\HttpFoundation\Response; //

$request = Request::createFromGlobals(); // atstoja init.php
*/

$name = $request->get('name', 'World');

$response->setContent(sprintf('Hello %s', htmlspecialchars($name, ENT_QUOTES, 'UTF-8'))); // pakeiciam new Response i: ->setContent

$response->send();


?>