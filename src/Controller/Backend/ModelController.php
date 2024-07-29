<?php

namespace App\Controller\Backend;

use App\Entity\Model;
use App\Form\ModelType;
use App\Repository\ModelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[route('/admin/model', name: 'app.admin.model')]
class ModelController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $em
    )
    {}

    #[Route('', name: '.index', methods:['GET'])]
    public function index(ModelRepository $repo): Response
    {
        return $this->render('backend/model/index.html.twig', [
            'model' => $repo->findall(),
        ]);
    }

    #[route('/create', name: '.create', methods:['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $model = new Model();
        $form = $this->createForm(ModelType::class, $model);
        $form->handleRequest($request);



    if($form->isSubmitted() && $form->isValid() ){
            $this->em->persist($model);
            $this->em->flush();

            $this->addFlash('sucess', 'Le model à bien été crée');

            return $this->redirectToRoute('app.admin.model.index');
        }

        
        return $this->render('Backend/Model/create.html.twig', [
            'form' => $form
        ]);
    }
}
