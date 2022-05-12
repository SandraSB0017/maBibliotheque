<?php

namespace App\Data;

use App\Entity\Auteur;
use App\Entity\Livre;
use Symfony\Component\Validator\Constraints as Assert;

class SearchData {

    /**
     * @var int
     */
    public $page = 1;

    /**
     * @var string
     */
    public $q = '';


    /**
     * @var Auteur
     */
    public $auteur;

    /**
     * @var string
     */
    public $titre ;

    /**
     * @var string
     */
    public $proprietaire;


    public $type;



    public $dateDebut;


    /*
    *@Assert\LessThan(propertyPath="$dateFin", message="doit être plus petit que $dateDebut)
    */
    public $dateFin;

}
