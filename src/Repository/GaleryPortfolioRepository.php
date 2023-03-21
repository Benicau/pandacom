<?php

namespace App\Repository;

use App\Entity\GaleryPortfolio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GaleryPortfolio>
 *
 * @method GaleryPortfolio|null find($id, $lockMode = null, $lockVersion = null)
 * @method GaleryPortfolio|null findOneBy(array $criteria, array $orderBy = null)
 * @method GaleryPortfolio[]    findAll()
 * @method GaleryPortfolio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GaleryPortfolioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GaleryPortfolio::class);
    }

    public function save(GaleryPortfolio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GaleryPortfolio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return GaleryPortfolio[] Returns an array of GaleryPortfolio objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GaleryPortfolio
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
