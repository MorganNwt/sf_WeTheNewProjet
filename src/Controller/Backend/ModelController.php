<?php

namespace App\Controller\Backend;

use App\Repository\ModelRepository;
use Doctrine\ORM\EntityManagerInterface;
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
}
