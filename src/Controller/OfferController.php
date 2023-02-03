<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\User;
use App\Entity\Souscription;
use App\Form\OfferType;
use App\Repository\OfferRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/offer")
 */
class OfferController extends AbstractController
{
    /**
     * @Route("/", name="offer_index", methods={"GET"})
     */
    public function index(OfferRepository $offerRepository): Response
    {
        return $this->render('offer/index.html.twig', [
            'offers' => $offerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="offer_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $offer = new Offer();
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offer);
            $entityManager->flush();

            return $this->redirectToRoute('offer_index');
        }

        return $this->render('offer/new.html.twig', [
            'offer' => $offer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="offer_show", methods={"GET"})
     */
    public function show(Offer $offer): Response
    {
        return $this->render('offer/show.html.twig', [
            'offer' => $offer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="offer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Offer $offer): Response
    {
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('offer_index');
        }

        return $this->render('offer/edit.html.twig', [
            'offer' => $offer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="offer_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Offer $offer): Response
    {
        if ($this->isCsrfTokenValid('delete' . $offer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($offer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('offer_index');
    }

    /**
     * @Route("/subscribe_to_offer/{id}", name="offer_subscribe", methods={"GET"})
     */
    public function subscribeToOffer(Offer $offer, UserRepository $userRepository, OfferRepository $offerRepository): Response
    {
        if ($this->getUser()) {
            $count = 0;
            $user = $this->getUser();
            if ($user->getVille() == "" || $user->getPays() == "" || $user->getNumSecu() == "" || $user->getCodePostal() == "" || $user->getTelephone() == "") {
                $this->addFlash( 'success','Vous devez rentrer toutes vos donnée');
                return $this->render('espace-client/index.html.twig');
            } else {
                foreach ($user->getSouscription() as $subscription) {
                    if ($subscription->getOffer() == $offer) {
                        $count++;
                    }
                }
                if ($count == 0) {
                    $souscription = new Souscription($user, $offer);
                    $user->addSouscription($souscription);
                    $offer->addSouscription($souscription);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($souscription);
                    $em->flush();
                    return $this->render('espace-client/souscription.html.twig', [
                        'souscription' => $user->getSouscription(),
                    ]);
                }
            }
        }
        else{
            $this->addFlash( 'success','Vous devez être connecté.e pour souscrire à une offre');

            return $this->redirectToRoute('app_login');
        }

    }
}