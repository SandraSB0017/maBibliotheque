<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuteurController extends AbstractController
{
    /**
     * @Route("/auteur", name="app_auteur")
     */
    public function index(): Response
    {

        $auteur =new Auteur();
        $auteurForm=$this->createForm(AuteurType::class,$auteur);



        return $this->render('auteur/index.html.twig', [
            'auteurForm'=>$auteurForm->createView()
        ]);
    }
}
