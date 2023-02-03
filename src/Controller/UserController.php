<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserAdminType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mon-espace-client")
 */
class UserController extends AbstractController
{
    /**
     * @Route("", name="user_home", methods={"GET","POST"})
     */
    public function index(UserRepository $userRepository, Request $request): Response
    {

        return $this->render('espace-client/index.html.twig', []);
    }
    /**
     * @Route("/modify", name="user_modify", methods={"GET","POST"})
     */
    public function Usermodify(UserRepository $userRepository, Request $request): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Créer un formulaire lié à ce utilisateur
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('espace-client/add_information.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("user/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/mes-souscriptions", name="user_souscriptions", methods={"GET"})
     */
    public function souscriptionUser(UserRepository $userRepository): Response
    {
        $user = $this->getUser();

        return $this->render('espace-client/souscription.html.twig', [
            'souscription' => $user->getSouscription(),
        ]);
    }


}
