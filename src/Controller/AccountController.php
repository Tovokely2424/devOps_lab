<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditionType;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
        //dump($errors);
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
     * @Route("/compte/{slug}", name="account_profile")
     */
    public function profile(){
        $user = $this->getUser();
        return $this->render('account/profile.html.twig',[
            'user'=>$user
        ]);
    }

    /**
     * Permet d'editer un profil utilisateur
     * @Route("/compte/{slug}/edit", name="account_edit")
     */
    public function edit_profile(Request $request, EntityManagerInterface $manager, $slug){
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['slug'=>$slug]);
        $form = $this->createForm(EditionType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted($request) && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', "Les modifications de l'annonce <strong>{$user->getSlug()}</strong> a été enregidtrée avec succès");
            return $this->redirectToRoute('account_profile', [
                'slug' => $user->getSlug()
            ]);
        }
        return $this->render('account/edition.html.twig', [
            'form' => $form->createView()
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

    /**
     * Permet de modifier le mot de passe
     * @Route("/compte/{slug}/password_update", name="account_password")
     * @return Response
     */
    public function update_password(UserPasswordHasherInterface $hasher, Request $request, EntityManagerInterface $manager, $slug){
        $passwordUpdate = new PasswordUpdate();
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['slug'=>$slug]);
        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!$hasher->isPasswordValid($user, $passwordUpdate->getOldPassword())) {
                $form->get('oldPassword')->addError(new FormError("Mod de passe incorrecte"));
            }
            else {
                $passwordValid = $hasher->hashPassword($user, $passwordUpdate->getNewPassword());
                $user->setHash($passwordValid);
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('success', 'Le mot de passe a été reinitialisé');
                return $this->redirectToRoute('account_login');
            }
        }
        return $this->render(
            'account/password_update.html.twig',[
                'form'=>$form->createView()
            ]
        );
    }
}
