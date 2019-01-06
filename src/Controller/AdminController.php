<?php

namespace App\Controller;

use App\Document\Category;
use App\Form\CategoryType;
use App\Form\ListSortType;
use App\Form\SubscriberType;
use App\Repository\CategoryRepository;
use App\Repository\SubscriberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * App\Controller\AdminController
 *
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @var SubscriberRepository
     */
    protected $subscriberRepository;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * AdminController constructor.
     *
     * @param SubscriberRepository $subscriberRepository
     * @param CategoryRepository   $categoryRepository
     */
    public function __construct(
        SubscriberRepository $subscriberRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->subscriberRepository = $subscriberRepository;
        $this->categoryRepository = $categoryRepository;
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
    public function subscriberList(Request $request): Response
    {
        $sortForm = $this->createForm(ListSortType::class);
        $sortForm->handleRequest($request);
        $sort = $sortForm->getData()['sort'];

        $subscribers = $this->subscriberRepository->find([], $sort ? [$sort] : []);
        $categories = $this->categoryRepository->find();

        return $this->render(
            'subscribesList.html.twig',
            [
                'subscribers' => $subscribers,
                'categories'  => $categories,
                'sortForm'    => $sortForm->createView(),
            ]
        );
    }

    /**
     * @Route("/edit/{id}")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function editSubscriber(Request $request): Response
    {
        $subscriber = $this->subscriberRepository
            ->findOne(['id' => $request->get('id')]);

        if (empty($subscriber)) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(SubscriberType::class, $subscriber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->subscriberRepository->save($subscriber);

            return $this->redirectToRoute('app_admin_subscriberlist');
        }

        return $this->render(
            'index.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route("/remove/{id}")
     *
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @throws \Exception
     */
    public function removeSubscriber(Request $request): RedirectResponse
    {
        $subscriber = $this->subscriberRepository
            ->findOne(['id' => $request->get('id')]);

        if (empty($subscriber)) {
            throw $this->createNotFoundException();
        }

        $id = $request->get('id');
        $this->subscriberRepository->remove($id);

        return $this->redirectToRoute('app_admin_subscriberlist');
    }

    /**
     * @Route("/category")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function createCategory(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryRepository->save($category);

            return $this->redirectToRoute('app_admin_subscriberlist');
        }

        return $this->render(
            'category.html.twig',
            ['form' => $form->createView()]
        );
    }
}
