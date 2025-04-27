<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
     /**
     * Permet de se connecter
     * @Route("/login", name="account_login")
     * @return Response
     */
    public function login(AuthenticationUtils $utils): Response
    {
        $errors = $utils->getLastAuthenticationError();
        dump($errors);
        $last_username = $utils->getLastUsername();
        return $this->render('account/login.html.twig', [
            'hasError' => $errors !== null,
            'last_username' => $last_username
        ]);
    }
    /**
     * Permet de se deconnecter
     * @Route("/logout", name="account_logout")
     * @return void
     */
    public function logout(){
        //
    }

    /**
     * Permet d'afficher le profile de l'utilisateur
     * @Route("/compte", name="account_profile")
     */
    public function profile(){
        $user = $this->getUser();
        return $this->render('account/profile.html.twig',[
            'user'=>$user
        ]);
    }

    /**
     * Permet à l'utilisateur de s'inscrire
     * @Route("/registration", name="account_registration")
     * @return Response
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder){
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted($request) && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', "L'Utilisateur <strong> {$user->getLastName()} {$user->getFirstName() } </strong> a été créé");
           return $this->redirectToRoute('account_login');
        }
        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
