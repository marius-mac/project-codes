<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{

    /**
     * @Route("/student", name="student")
     */
    public function index(Request $request)
    {
        return $this->render('student/index.html.twig', [
            'name' => $request->get('name'),
            'project' => $request->get('project')
        ]);
    }
}
