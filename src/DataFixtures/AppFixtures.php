<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use App\Entity\Livre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
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
            }
        }


        $manager->flush();

    }
}
