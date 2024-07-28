<?php

namespace App\Controller\Backend;

use App\Entity\Gender;
use App\Form\GenderType;
use App\Repository\GenderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[route('/admin/gender', name: 'app.admin.gender' )] 
class GenderController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
    ){
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(GenderRepository $repo): Response
    {
        return $this->render('backend/gender/index.html.twig', [
            'gender' => $repo->findAll(),
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        // On créé un nouvel objet 
        $gender = new Gender();

        // On crée notre formulaire en lui passant l'objet qu'il doit remplir
        $form = $this->createForm(GenderType::class, $gender);

        // On passe la request au formulaire pour qu'il puisse récupérer les données
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, on persiste l'objet en base de données
        if($form->isSubmitted() && $form->isValid() ){
            // $categorie->setCreatedAt( new \DateTimeImmutable() );

            // On met en file d'attente l'objet à persister
            $this->em->persist($gender);

            // On exécute la file d'attente
            $this->em->flush();

            // On créé un message flash pour informer l'utilisateur que la catégorie a bien été crée
            $this->addFlash('sucess', 'Le genre à bien étét crée');

            return $this->redirectToRoute('app.admin.gender.index');
        }

        return $this->render('backend/gender/create.html.twig', [
           'form' => $form
        ]);
    }

    #[route('/{id}/update', name: '.update', methods: ['GET', 'POST'])]
    public function update(?Gender $gender, Request $request): Response|RedirectResponse
    {
        if (!$gender){
            $this->addFlash('error', 'Utilisateur introuvable');

          return $this->redirectToRoute('app.admin.gender.index');
        }

        $form = $this->createForm(GenderType::class, $gender, );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $this->em->persist($gender);
            $this->em->flush();

            $this->addFlash('success', 'Utilisateur mis à jour avec succès');

            return $this->redirectToRoute('app.admin.gender.index');
        }

        return $this->render('Backend/gender/update.html.twig', [
            'form'=> $form,
        ]);
    }

    #[route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function delete(?Gender $gender, Request $request): Response|RedirectResponse
    {
        if(!$gender){
            $this->addFlash('error', 'Utilisateur introuvable');

            return $this->redirectToRoute('app.admin.gender');
        }

        if($this->isCsrfTokenValid('delete'. $gender->getId(), $request->request->get('token'))) {
            $this->em->remove($gender);
            $this->em->flush();

            $this->addFlash('success', 'Le genre à bien été supprimé');
        }else{
            $this->addFlash('error', 'Le token csrf est invalide');
        }  

        return $this->redirectToRoute('app.admin.gender.index');
    }
}

