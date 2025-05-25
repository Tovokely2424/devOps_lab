<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{slug}", name="user_show")
     * @param User $user
     * @param UserRepository $repo
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */

    public function index(UserRepository $repo, $slug): Response
    {
        $user = $repo->findOneBy(['slug' => $slug]);
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user,
        ]);
    }

    /**
     * Permet d'afficher la page compte de l'utilisateur connecté
     * @Route("/account", name="user_account")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function myaccount() :Response   
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('account_login');
        }
        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }
}
