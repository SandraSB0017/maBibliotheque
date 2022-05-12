<?php

namespace App\Repository;


use App\Data\SearchData;
use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livre>
 *
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Livre $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Livre $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param SearchData $search $
     * @return array*
     */



public function searchLivre(SearchData $search):array

{
    $query = $this
        ->createQueryBuilder('l')
        ->select('a', 'l')
        ->join('l.auteur', 'a');


    if (!empty($search->q)) {
        $query = $query
            ->andWhere('l.titre LIKE :q')
            ->setParameter('q', "%{$search->q}%");
    }

    if (!empty($search->auteur)) {
        $query = $query
            ->andWhere('l.auteur = :auteur')
            ->setParameter('auteur', $search->auteur);
    }

    if (!empty($search->proprietaire)) {
        $query = $query
            ->andWhere('l.proprietaire = :proprietaire')
            ->setParameter('proprietaire', $search->proprietaire);
    }

    if (!empty($search->type)) {
        $query = $query
            ->andWhere('l.type = :type')
            ->setParameter('type', $search->type);
    }

    if (!empty($search->dateDebut)) {
        $query = $query
            ->andWhere('l.annee >= :dateDebut')
            ->setParameter('dateDebut', $search->dateDebut);
    }

    if (!empty($search->dateFin)) {
        $query = $query
            ->andWhere('l.annee <= :dateFin')
            ->setParameter('dateFin', $search->dateFin);
    }

    return $query->getQuery()->getResult();
}




    // /**
    //  * @return Livre[] Returns an array of Livre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Livre
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
