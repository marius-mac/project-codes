<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Vehicle;
use AppBundle\Entity\VehicleSearch;
use AppBundle\Type\ProfileFormType;
use AppBundle\Type\VehicleSearchType;
use FOS\UserBundle\Form\Type\ChangePasswordFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $searchForm = $this->createForm(
            VehicleSearchType::class, null, [
            'action' => $this->generateUrl('detailed_search'),
            ]
        );
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            return $this->getResults($searchForm);
        }
        return $this->render(
            'AppBundle:pages:index.html.twig',
            ['searchForm' => $searchForm->createView()]
        );
    }

    /**
     * @Route("/search/{page}", name="detailed_search", requirements={"page": "^[1-9]\d*$"})
     */
    public function searchAction(Request $request, $page = 1)
    {
        $searchForm = $this->createForm(VehicleSearchType::class);
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $vehicleSearch = $searchForm->getData();
            if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                $entityManager = $this->get('doctrine.orm.default_entity_manager');
                $repo = $entityManager->getRepository('AppBundle:VehicleSearch');
                $user = $this->getUser();
                if (!$user->getPinnedVehicles()->contains($vehicleSearch)) {
                    $vehicleSearch->setUser($user);
                    // remove outdated searches and insert new one
                    $outdatedSearches = $repo->getOutdatedSearches($user);
                    foreach ($outdatedSearches as $outSearch) {
                        $entityManager->remove($outSearch);
                    }
                    $entityManager->persist($vehicleSearch);
                    $entityManager->flush();
                }
                return $this->getResults($searchForm, $page, $vehicleSearch->getId());
            }
            return $this->getResults($searchForm, $page, null);
        }
        return $this->render(
            'AppBundle:pages:detailed_search.html.twig', [
            'searchForm' => $searchForm->createView()
            ]
        );
    }

    /**
     * @Route(
     *     "/vehicle/{pinAction}/{id}",
     *     name="pin_vehicle",
     *     options = {"expose" = true},
     *     requirements={"id": "\d+", "pinAction": "pin|unpin"}
     * )
     */
    public function pinVehicleAction($id, $pinAction)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return new JsonResponse(['error' => 'auth-error']);
        }
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $repository = $entityManager->getRepository('AppBundle:Vehicle');
        $vehicle = $repository->find($id);
        if ($vehicle === null) {
            return new JsonResponse(['error' => 'vehicle was not found']);
        }
        $user = $this->getUser();
        $translator = $this->get('translator.default');
        if ($pinAction === 'pin') {
            if ($user->getPinnedVehicles()->contains($vehicle)) {
                return new JsonResponse(['error' => 'pinning already pinned vehicle']);
            }
            $user->addPinnedVehicle($vehicle);
            $entityManager->persist($user);
            $entityManager->flush();
            return new JsonResponse(
                [
                'pin_action' => 'unpin',
                'button_text' => $translator->trans('results.pin.pinned'),
                ]
            );
        } elseif ($pinAction === 'unpin') {
            $user->removePinnedVehicle($vehicle);
            $entityManager->persist($user);
            $entityManager->flush();
            return new JsonResponse(
                [
                'pin_action' => 'pin',
                'button_text' => $translator->trans('results.pin.unpinned'),
                ]
            );
        } else {
            return new JsonResponse(['error' => 'action not implemented']);
        }
    }

    /**
     * @Route("/pinned/{page}", name="pinned", requirements={"page": "^[1-9]\d*$"})
     */
    public function pinnedVehiclesAction($page = 1)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return new JsonResponse(['error' => 'auth-error']);
        }
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $repository = $entityManager->getRepository('AppBundle:Vehicle');
        $user = $this->getUser();
        $results = $repository->getPinnedVehicles($user, $page);
        return $this->render(
            'AppBundle:pages:pinned_page.html.twig', [
            'items' => $results['vehicles'],
            'total_pages_count' => $results['total_pages_count'],
            ]
        );
    }

    /**
     * @Route("/searches/results/{id}/{page}",
     *     name="searches_view_results",
     *     requirements={"page": "^[1-9]\d*$", "id": "\d+"})
     */
    public function searchesViewResultsAction($id, $page = 1)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return new JsonResponse(['error' => 'not authenticated']);
        }
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $repository = $entityManager->getRepository('AppBundle:VehicleSearch');
        $user = $this->getUser();
        $vehicleSearch = $repository->findOneBy(['id' => $id, 'user' => $user->getId()]);
        if ($vehicleSearch == null) {
            return new JsonResponse(['error' => 'vehicle search was not found']);
        }
        $searchForm = $this->createForm(VehicleSearchType::class);
        return $this->getResults($searchForm, $page, $vehicleSearch->getId());
    }

    /**
     * @Route("/settings", name="settings")
     */
    public function settingsAction()
    {
        $changePasswordForm = $this->createForm(ChangePasswordFormType::class);
        $editProfileForm = $this->createForm(ProfileFormType::class);
        return $this->render('AppBundle:pages:settings_page.html.twig', [
            'changePasswordForm' => $changePasswordForm->createView(),
            'editProfileForm' => $editProfileForm->createView(),
        ]);
    }

    private function getResults(Form $searchForm, $page = 1, $vehicleSearchId = null)
    {
        $entityManager = $this->get('doctrine.orm.default_entity_manager');

        if ($vehicleSearchId == null) {
            $vehicleSearch = $searchForm->getData();
        } else {
            $vehicleSearch = $entityManager->getRepository('AppBundle:VehicleSearch')
                ->findOneBy(['id' => $vehicleSearchId]);
            if (!($searchForm->isSubmitted() && $searchForm->isValid())) {
                $searchForm->setData($vehicleSearch);
            }
        }
        $results = $entityManager->getRepository('AppBundle:Vehicle')
            ->findAllByCriteria($vehicleSearch, $page);
        return $this->render(
            'AppBundle:pages:results_page.html.twig', [
                'items' => $results['vehicles'],
                'total_pages_count' => $results['total_pages_count'],
                'searchForm' => $searchForm->createView(),
                'vehicleSearch' => ($vehicleSearchId !== null) ? $vehicleSearch : null,
            ]
        );
    }
}
