<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use App\Entity\Livre;
use App\Entity\PostLike;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
{
    $this->encoder =$encoder;
}


    public function load(ObjectManager $manager): void
    {

        $auteur1 = new Auteur();
        $auteur1->setNom("Despentes");
        $auteur1->setPrenom("Virginie");
        $manager->persist($auteur1);

        $auteur2 = new Auteur();
        $auteur2->setNom(" de Beauvoir");
        $auteur2->setPrenom("Simone");
        $manager->persist( $auteur2);


        $auteur3 = new Auteur();
        $auteur3->setNom(" Coben");
        $auteur3->setPrenom("Harlan");
        $manager->persist( $auteur3);

        $auteur4 = new Auteur();
        $auteur4->setNom("Bagieu");
        $auteur4->setPrenom("Pénélope");
        $manager->persist( $auteur4);

        $auteurs = [$auteur1,$auteur2,$auteur3,$auteur4];

        $faker = \Faker\Factory::create('fr_FR');


        $user = new User();
        $users [] = $user;
        for($i = 0; $i<20; $i++)
        {
            $user = new User();
            $user->setEmail($faker->email)
                ->setPassword($this->encoder->hashPassword($user, 'azerty'))
                ->setPrenom($faker->userName)
                ->setNom($faker->name)
                ->setPseudo($faker->userName);

            $manager->persist( $user);
            $users [] = $user;
        }



        foreach($auteurs as $a){
            $rand = rand(1,3);
            for($i=1; $i<=$rand; $i++){
                $livre = new Livre();
                $livre->setTitre($faker->sentence($nbWords = 2, $variableNbWords = true));
                $livre->setPhoto($faker->imageUrl($width = 640, $height = 480));
                $livre->setAnnee($faker->numberBetween($min = 1900, $max = 2022));
                $livre->setResume($faker->text($maxNbChars = 400));
                $livre->setProprietaire($faker->randomElement($array = array ('Jules','Dom','Nina', 'Sandra')));
                $livre->setType($faker->randomElement($array = array ('Roman','Bd','Essai', 'Manga', 'Roman Graphique')));
                $livre->setAuteur($a);
                $manager->persist( $livre);

                for($j=0; $j< mt_rand(0, 10); $j++){
                    $like = new PostLike();
                    $like->setPost($livre)
                        ->setUser($faker->randomElement($users));
                    $manager->persist($like);
                }

            }
        }







        $manager->flush();

    }
}
