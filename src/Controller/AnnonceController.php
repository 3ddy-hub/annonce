<?php

namespace App\Controller;

use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/", name="annonce")
     */
    public function index(OffreRepository $offre_repository): Response
    {
        return $this->render('annonce/index.html.twig', [
            'offres' => $offre_repository->findBy([], ['id' => 'ASC'])
        ]);
    }
}
