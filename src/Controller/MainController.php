<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Livre;
use App\Form\AuteurType;
use App\Form\LivreType;
use App\Form\SearchForm;
use App\Repository\AuteurRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Data\SearchData;

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


    /**
     * @Route("/recherche", name="recherche")
     */
    public function recherche(LivreRepository $livreRepository, Request $request)
    {
        $data = new SearchData();
        //$data->page = $request->get('page', 1);
        $form = $this->createForm(SearchForm::class,$data);


      // $livre = new Livre();
   //$livreForm = $this->createForm(LivreType::class, $livre);

     return $this->render ('main/home.html.twig',[
           'searchForm'=>$form->createView()
      ]);
//
  }




}
