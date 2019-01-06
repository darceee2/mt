<?php

namespace App\Controller;

use App\Document\Subscriber;
use App\Form\SubscriberType;
use App\Service\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * App\Controller\DefaultController
 */
class DefaultController extends AbstractController
{
    /**
     * @var DocumentManager
     */
    protected $documentManager;

    /**
     * DefaultController constructor.
     *
     * @param DocumentManager $documentManager
     */
    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    /**
     * @Route("/")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function index(Request $request): Response
    {
        $subscriber = new Subscriber();
        $form = $this->createForm(SubscriberType::class, $subscriber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->documentManager->save($subscriber);
        }

        return $this->render('index.html.twig', ['form' => $form->createView()]);
    }
}
