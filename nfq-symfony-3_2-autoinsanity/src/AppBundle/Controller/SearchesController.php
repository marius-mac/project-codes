<?php

namespace AppBundle\Controller;

use AppBundle\Repository\VehicleSearchRepository;
use AppBundle\Type\VehicleSearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/searches")
 */
class SearchesController extends Controller
{
    /**
     * @Route("/{page}", name="searches", requirements={"page": "^[1-9]\d*$"})
     */
    public function savedSearchesAction($page = 1)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return new JsonResponse(['error' => 'not authenticated']);
        }
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $repository = $entityManager->getRepository('AppBundle:VehicleSearch');
        $user = $this->getUser();
        $recentSearches = $repository->getRecentSearches($user);
        $savedSearches = $repository->getSavedSearches($user, $page);
        return $this->render(
            'AppBundle:pages:searches_page.html.twig', [
                'searches_recent' => $recentSearches,
                'searches_saved' => $savedSearches['vehicles'],
                'total_pages_count' => $savedSearches['total_pages_count'],
                'pageSearchCount' => $repository::MAX_SEARCHES_PER_USER,
            ]
        );
    }

    /**
     * @Route(
     *     "/{pinAction}/{id}",
     *     name="pin_vehicle_search",
     *     options = {"expose" = true},
     *     requirements={"id": "\d+", "pinAction": "pin|unpin"}
     * )
     */
    public function pinVehicleSearchAction($pinAction, $id = null)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return new JsonResponse(['error' => 'auth-error']);
        }
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $repository = $entityManager->getRepository('AppBundle:VehicleSearch');
        $user = $this->getUser();
        $translator = $this->get('translator.default');

        $vehicleSearch = $repository->findOneBy(['id' => $id, 'user' => $user->getId()]);

        if ($vehicleSearch === null) {
            return new JsonResponse(['error' => 'vehicle search was not found']);
        }
        if ($pinAction === 'pin') {
            $vehicleSearch->setPinned(1);
            $entityManager->persist($vehicleSearch);
            $entityManager->flush();
            return new JsonResponse(
                [
                    'pin_action' => 'unpin',
                    'button_text' => $translator->trans('searches.pin.pinned'),
                ]
            );
        } elseif ($pinAction === 'unpin') {
            $vehicleSearch->setPinned(0);
            $entityManager->persist($vehicleSearch);
            $entityManager->flush();
            return new JsonResponse(
                [
                    'pin_action' => 'pin',
                    'button_text' => $translator->trans('searches.pin.unpinned'),
                ]
            );
        } else {
            return new JsonResponse(['error' => 'action not implemented']);
        }
    }
}
