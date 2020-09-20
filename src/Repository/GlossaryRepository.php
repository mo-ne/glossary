<?php

namespace App\Repository;

use App\Entity\GlossaryEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
* @method GlossaryEntry|null find($id, $lockMode = null, $lockVersion = null)
* @method GlossaryEntry|null findOneBy(array $criteria, array $orderBy = null)
* @method GlossaryEntry[]    findAll()
* @method GlossaryEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
*/
class GlossaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GlossaryEntry::class);
    }

    /**
     * Returns glossary entry by given term.
     *
     * @param string $term Relates to field 'term' in database
     *
     * @return ?GlossaryEntry
     */
    public function findByTerm(string $term): ?GlossaryEntry
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
        return $this->findByTerm($term) !== null;
    }

    /**
     * Returns all entries from database.
     *
     * @return array
     */
    public function getAllEntries(): array
    {
        $query = $this->createQueryBuilder('g')
            ->select('g.id', 'g.term', 'g.description', 'g.relevance')
            ->getQuery();

        return $query->getResult();
    }
}
