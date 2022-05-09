<?php

namespace App\Controller;

use App\Repository\AuteurRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{


    /**
     * @Route("/", name="main_home")
     */
    public function list(LivreRepository $livreRepository, AuteurRepository $auteurRepository): Response
    {
        $livres = $livreRepository->findAll();


        return $this->render('main/home.html.twig',[
            'livres'=> $livres,

        ]);
    }



}
