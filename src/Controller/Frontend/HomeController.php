<?php
namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; // <- va permettre de pouvoir récupérer lareponse de la requete
use Symfony\Component\Routing\Annotation\Route; // <- va permettre de définir les routespour les functions

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return$this->render('base.html.twig');
    }
}