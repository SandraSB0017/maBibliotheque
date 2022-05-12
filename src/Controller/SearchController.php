<?php

namespace App\Controller;


use App\Data\SearchData;
use App\Form\SearchForm;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function searchLivre(Request $request, LivreRepository $livreRepository): Response
    {

        $data = new SearchData();
        $searchLivreForm = $this->createForm(SearchForm::class, $data);
        $searchLivreForm->handleRequest($request);
        $livres = $livreRepository->searchLivre($data);

        return $this->render('search/searchLivres.html.twig', [
            'livres'=> $livres,
            'searchLivreForm'=>$searchLivreForm->createView()
        ]);
    }



}
