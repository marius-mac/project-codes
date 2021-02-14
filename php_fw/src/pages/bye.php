<?php

require_once __DIR__.'/.../init.php'; // require_once __DIR__.'/vendor/autoload.php';

/*
use Symfony\Component\HttpFoundation\Request; // panaudojam sukurta vedor/autoload.php
use Symfony\Component\HttpFoundation\Response; //

$request = Request::createFromGlobals(); // atstoja init.php
*/

$response->setContent('Goodbye!'); // pakeiciam new Response i ->setContent

$response->send();

?>