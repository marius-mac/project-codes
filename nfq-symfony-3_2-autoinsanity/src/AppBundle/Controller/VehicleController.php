<?php

namespace AppBundle\Controller;

use PHP_CodeSniffer\Reports\Json;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vehicle")
 */
class VehicleController extends Controller
{
    /**
     * @Route("/getmodels/{id}", name="get_models", options = {"expose" = true}, requirements={"id": "\d+"})
     */
    public function getModelsAction($id = null)
    {
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $repo = $entityManager->getRepository('AppBundle:Model');
        $models = $repo->findBy(['brand' => $id], ['name' => 'ASC']);
        $jsonModels = json_encode($models);
        return new JsonResponse($jsonModels);
    }

    /**
     * @Route("/getcities/{id}", name="get_cities", options = {"expose" = true}, requirements={"id": "\d+"})
     */
    public function getCitiesAction($id = null)
    {
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $repo = $entityManager->getRepository('AppBundle:City');
        $cities = $repo->findBy(['country' => $id], ['name' => 'ASC']);
        $jsonModels = json_encode($cities);
        return new JsonResponse($jsonModels);
    }
}
