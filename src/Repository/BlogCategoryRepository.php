<?php

namespace App\Repository;

use App\Entity\BlogCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * @method BlogCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogCategory[]    findAll()
 * @method BlogCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BlogCategory::class);
    }

    public function findAllQB(): QueryBuilder
    {
        return $this->createQueryBuilder('bc')
            ->orderBy('bc.name', 'ASC')
        ;
    }

    public function findAvailableSortedByName(): QueryBuilder
    {
        return $this->createQueryBuilder('bc')
            ->andWhere('bc.isAvailable = :available')
            ->setParameter('available', true)
            ->orderBy('bc.name', 'ASC')
        ;
    }

    public function findAvailableAndSlugSortedByName(string $slug): QueryBuilder
    {
        return $this->findAvailableSortedByName()
            ->andWhere('bc.slug = :slug')
            ->setParameter('slug', $slug)
        ;
    }

    public function findLocalizedSlugAvailableSortedByName(string $locale, string $slug): QueryBuilder
    {
        return $this->findAvailableSortedByName()
            ->join('bc.translations', 't')
            ->andWhere('t.locale = :locale')
            ->andWhere('t.content = :content')
            ->andWhere('t.field = :field')
            ->setParameter('locale', $locale)
            ->setParameter('content', $slug)
            ->setParameter('field', 'slug')
        ;
    }
}
