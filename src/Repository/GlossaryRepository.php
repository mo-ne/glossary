<?php

namespace App\Repository;

use App\Entity\Glossary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
* @method Glossary|null find($id, $lockMode = null, $lockVersion = null)
* @method Glossary|null findOneBy(array $criteria, array $orderBy = null)
* @method Glossary[]    findAll()
* @method Glossary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
*/
class GlossaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Glossary::class);
    }

    /**
     * Returns glossary entry by given term.
     *
     * @param string $term Relates to field 'term' in database
     *
     * @return ?Glossary
     */
    public function findByTerm(string $term): ?Glossary
    {
        $query = $this->createQueryBuilder('g')
            ->where('g.term = :term')
            ->setParameter('term', $term)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * Checks if term already exists in database.
     *
     * @param string $term Relates to field 'term' in database
     *
     * @return bool
     */
    public function checkByTerm(string $term): bool
    {
        return $this->findByTerm() !== null;
    }

    /**
     * Returns all entries from database.
     *
     * @return Glossary
     */
    public function getAllEntries(): Glossary
    {
        $query = $this->createQueryBuilder('g')
            ->select('g.id', 'g.term', 'g.description', 'g.relevance')
            ->getQuery();

        return $query->getResult();
    }
}
