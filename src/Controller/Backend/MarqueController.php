<?php

namespace App\Controller\Backend;

use App\Repository\MarqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[route('/admin/marque/', name:'app.admin.marque' )]
class MarqueController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $em
    ){
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(MarqueRepository $repo): Response
    {
        return $this->render('backend/marque/index.html.twig', [
            'marque' => $repo->findAll(),
        ]);
    }
}
