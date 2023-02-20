<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function add(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Post[] Returns an array of Post objects
    */
   public function findByOrderPostCreateDate(): array
   {
        return $this->createQueryBuilder('m')
            ->orderBy('m.createdAt', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
   }

   /**
    * Post by category
    *
    * @return Post[]
    */
   public function findByCategory($category): array
   {
       return $this->createQueryBuilder('p')
            ->join('p.categories', 'c')
            ->andWhere('c.id = :id')
            ->setParameter('id', $category)
            ->getQuery()
            ->getResult(); 
            
    }
   
    /**
     * Return all the posts by author
     *
     * @param [type] $author
     *
     * @return Post[]
     */
    public function findByAuthor($author): array
    {
        return $this->createQueryBuilder('p')
            ->join('p.author', 'a')
            ->andWhere('a.id = :id')
            ->setParameter('id', $author)
            ->getQuery()
            ->getResult();
    }
    
}
