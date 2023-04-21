<?php

namespace App\Repository;

use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trick>
 *
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private readonly int $tricksToShow)
    {
        parent::__construct($registry, Trick::class);
    }

    public function save(Trick $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Trick $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getPaginatedTricks(int $page = 1)
    {
        $page >= 1 ?: $page = 1;

        return $this->createQueryBuilder('t')
                    ->addSelect('c')
                    ->join('t.category', 'c')
                    ->setMaxResults($this->tricksToShow)
                    ->setFirstResult(($page - 1) * $this->tricksToShow)
                    ->orderBy('t.updatedAt', 'DESC')
                    ->addOrderBy('t.createdAt', 'DESC')
                    ->getQuery()
                    ->getResult();
    }
}
