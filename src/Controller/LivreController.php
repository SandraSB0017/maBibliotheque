<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Livre;
use App\Entity\PostLike;
use App\Form\AuteurType;
use App\Form\LivreType;
use App\Repository\AuteurRepository;
use App\Repository\LivreRepository;
use App\Repository\PostLikeRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class LivreController extends AbstractController
{
    /**
     * @Route("/livre", name="app_livre")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {

        $livre = new Livre();

         $livreForm = $this ->createForm(LivreType::class, $livre);

        $livreForm->handleRequest($request);


        if($livreForm->isSubmitted() && $livreForm->isValid()){

            $this->extracted_imgFile_Update($livreForm, $livre, $entityManager);

            $this->addFlash('success', 'le livre a été ajouté');
            return $this->redirectToRoute('main_home');

        }
        return $this->render('livre/create.html.twig',[
            'livreForm'=>$livreForm->createView(),
        ]);
    }

    /**
     * @Route("/livre/{id}/details", name="livre_detail")
     */
    public function detail( int $id,
                           EntityManagerInterface $entityManager,
                           LivreRepository $livreRepository): Response
    {

        $livre= $livreRepository->find($id);

        return $this->render('livre/details.html.twig',[
            'livre'=> $livre

        ]);
    }

    /**
     * @Route("/livre/{id}/update", name="livre_update")
     */
    public function update( int $id,
                            EntityManagerInterface $entityManager,
                            LivreRepository $livreRepository,
                            Request $request
    ): Response
    {

        $livre = $livreRepository->find($id);
        $livreForm = $this ->createForm(LivreType::class, $livre);

        $livreForm->handleRequest($request);

        if($livreForm->isSubmitted()){

            $this->extracted_imgFile_Update($livreForm, $livre, $entityManager);

            $this->addFlash('success', 'le livre a été modifié');
            return $this->redirectToRoute('main_home');

        }
        return $this->render('livre/update.html.twig',[
            'livre'=>$livre,
            'livreForm'=>$livreForm->createView(),
        ]);

    }

    /**
     * @Route("/livre/{id}/remove", name="livre_remove")
     */
    public function remove( int $id,
                            EntityManagerInterface $entityManager,
                            LivreRepository $livreRepository,
                            Request $request
    ): Response
    {

        $livre = $livreRepository->find($id);

        $entityManager->remove($livre);
        $entityManager->flush();

            $this->addFlash('success', 'le livre a été supprimé');
            return $this->redirectToRoute('main_home');

//        }
//        return $this->render('livre/update.html.twig',[
//            'livre'=>$livre
//
//        ]);

    }





    /**
     * @param \Symfony\Component\Form\FormInterface $livreForm
     * @param Livre|null $livre
     * @param EntityManagerInterface $entityManager
     * @return void
     */
    public function extracted_imgFile_Update(\Symfony\Component\Form\FormInterface $livreForm, ?Livre $livre, EntityManagerInterface $entityManager): void
    {
        $imgFile = $livreForm->get('photo')->getData();

        if ($imgFile) {
            $newFilename = $livre->getTitre() . "-" . $livre->getId() . "." . $imgFile->guessExtension();
            $imgFile->move($this->getParameter('images_directory'), $newFilename);
            $livre->setPhoto($newFilename);

        }


        $livre->setDateAjout(new \DateTime());
        $entityManager->persist($livre);


        $entityManager->flush();
    }


    /**
     *
     * Permet de liker ou unliker un article
     *
     * @Route("/livre/{id}/like", name="livre_like")
     *
     */

    public function like(Livre $livre, EntityManagerInterface $entityManager, PostLikeRepository $postLikeRepository) : Response
    {
            $user=$this->getUser();

            if(!$user) return $this->json([
                'code'=>403,
                'message'=> "Unauthorize"
            ],403);

            if($livre->isLikedByUser($user)){
                $like = $postLikeRepository->findOneBy([
                    'livre'=>$livre,
                    'user' =>$user
                ]);

                $entityManager->remove($like);
                $entityManager->flush();

                return $this->json([
                    'code'=> 200,
                    'message' => 'c\'est parfait',
                    'likes'=> $postLikeRepository->count(['livre' =>$livre])
                ],200);
            }
             $like = new PostLike();
            $like->setLivre($livre)
                ->setUser($user);
            $entityManager->persist($like);
            $entityManager->flush();


            return $this->json([
                'code'=>200,
                'message' => 'like bien ajouté',
                'likes' => $postLikeRepository->count(['livre' => $livre])
            ],200);
    }

}
