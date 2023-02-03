<?php

namespace App\Controller;

use App\Entity\Homepage;
use App\Form\HomepageType;
use App\Repository\HomepageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomepageController extends AbstractController
{
    /**
     * @Route("", name="index", methods={"GET"})
     */
    public function show(HomepageRepository $homepageRepository): Response
    {
        $homepageRepository->findAll();
        if( $homepageRepository->findAll() != null)
        {
            return $this->render('homepage/show.html.twig', [
                'homepage' => $homepageRepository->findAll()[0],
            ]);
        }
        else
        {
            return $this->render('homepage/show.html.twig', ['homepage' => null,]);
        }

    }

    /**
     * @Route("/admin/index", name="homepage_index", methods={"GET"})
     */
    public function indexHomepage(HomepageRepository $homepageRepository): Response
    {
        return $this->render('homepage/index.html.twig', [
            'homepages' => $homepageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/new", name="homepage_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $homepage = new Homepage();
        $form = $this->createForm(HomepageType::class, $homepage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($homepage);
            $entityManager->flush();

            return $this->redirectToRoute('homepage_index');
        }

        return $this->render('homepage/new.html.twig', [
            'homepage' => $homepage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}/edit", name="homepage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Homepage $homepage): Response
    {
        $form = $this->createForm(HomepageType::class, $homepage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('homepage_index');
        }

        return $this->render('homepage/edit.html.twig', [
            'homepage' => $homepage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="homepage_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Homepage $homepage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$homepage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($homepage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('homepage_index');
    }
}
