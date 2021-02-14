<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SimpleController extends Controller
{
    /**
    * @Route("/default/")
    */
    public function index()
    {
        return $this->render('default/hello.html.twig');
    }

    
}