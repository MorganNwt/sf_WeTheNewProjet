<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app.login', methods: ['GET', 'POST'])]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('Security/login.html.twig', [
        'last_username' => $lastUsername,
        'error' => $error,
        ]);
    }

    #[route('/register', name: 'app.register', methods: ['GET', 'POST'])]
    public function register(Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $em): Response|RedirectResponse
    {
        $user = new User;

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user
                ->setPassword($hasher->hashPassword($user, $form->get('password')->getData() )
            );
        
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre compte à bien été crée.');
            
            return $this->redirectToRoute('app.login');
        }
    
        return $this->render('Security/register.html.twig', [
            'form'=> $form,
        ]);
    }
}
