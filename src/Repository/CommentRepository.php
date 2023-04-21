<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 *
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private readonly int $nbCommentsToShow)
    {
        parent::__construct($registry, Comment::class);
    }

    public function save(Comment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Comment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getPaginatedComments(Trick $trick, int $page = 1)
    {
        $page >= 1 ?: $page = 0;

        return $this->createQueryBuilder('c')
                    ->where('c.trick = :trickId')
                    ->setParameter('trickId', $trick->getId()->toBinary())
                    ->setMaxResults($this->nbCommentsToShow)
                    ->setFirstResult($page * $this->nbCommentsToShow)
                    ->orderBy('c.createdAt', 'DESC')
                    ->getQuery()
                    ->getResult();
    }
}
