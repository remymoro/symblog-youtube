<?php

namespace App\Repository\Post;

use App\Entity\Post\Tag;
use App\Entity\Post\Post;
use App\Entity\Post\Category;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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
    public function __construct(
        ManagerRegistry $registry,
        private PaginatorInterface $paginatorInterface

    ) {
        parent::__construct($registry, Post::class);
    }



    // /**
    //  * @?Tag $tag
    //  * @?category $category
    //  * @param  paginationInterface 
    //  * @param  page int  
    //  */


    public function findPublished(
        int $page,
        ?Category  $category = null,
        ?Tag $tag = null

    ): PaginationInterface {


        $data = $this->createQueryBuilder('p')
            ->where('p.state LIKE :state')
            ->setParameter('state', '%STATE_PUBLISHED%')
            ->orderBy('p.createdAt', 'DESC');



        // modification jointure 
        if (isset($category)) {
            $data = $data
                // creation  alias
                ->join('p.categories', 'c')
                ->andWhere(':category IN (c)')
                ->setParameter('category', $category);
        }



        if (isset($tag)) {
            $data = $data
                ->join('p.tags', 't')
                ->andWhere(':tag IN (t)')
                ->setParameter('tag', $tag);
        }


        $data->getQuery()
            ->getResult();



        $posts = $this->paginatorInterface->paginate($data, $page, 9);


        return $posts;
    }
}
