<?php

namespace App\Repository;

use App\Entity\Appreciation;
use App\Entity\Services;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Appreciation>
 *
 * @method Appreciation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appreciation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appreciation[]    findAll()
 * @method Appreciation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppreciationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appreciation::class);
    }

    public function save(Appreciation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Appreciation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function getSujetsPlusParles()
    {
        $sql = "SELECT sujet_id, COUNT(*) AS nb_occurrences
                FROM appreciation
                GROUP BY sujet_id
                ORDER BY nb_occurrences DESC
                LIMIT 10";
    
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addScalarResult('sujet_id', 'sujet_id');
        $rsm->addScalarResult('nb_occurrences', 'nbOccurrences');
    
        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);
        $results = $query->getResult();
    
        $sujetsPlusParles = new ArrayCollection();
    
        foreach ($results as $result) {
            $sujetPlusParle = new Appreciation();
            $sujet = $this->getEntityManager()->getRepository(Services::class)->find($result['sujet_id']);
            $sujetPlusParle->setSujet($sujet);
            $sujetPlusParle->setNbOccurences($result['nbOccurrences']);
            $sujetsPlusParles->add($sujetPlusParle);
        }
    
        return $sujetsPlusParles;
    }
  
    

//    /**
//     * @return Appreciation[] Returns an array of Appreciation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Appreciation
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
