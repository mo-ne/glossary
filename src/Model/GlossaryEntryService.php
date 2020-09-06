<?php

namespace App\Model;

use App\Entity\GlossaryEntry;
use App\Repository\GlossaryRepository;
use Doctrine\ORM\EntityManagerInterface;

class GlossaryEntryService implements GlossaryEntryServiceInterface
{
    /**
     * @var GlossaryRepository
     */
    private $glossaryRepository = null;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager = null;

    /**
     * GlossaryEntryService consructor.
     *
     * @param GlossaryRepository $glossaryRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        GlossaryRepository $glossaryRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->glossaryRepository = $glossaryRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * Inserts new entry.
     *
     * @param GlossaryEntry $glossaryEntry
     *
     * @return bool
     */
    public function insertEntry(GlossaryEntry $glossaryEntry): bool
    {
        if ($this->findEntry($glossaryEntry->getTerm()) == null) {
            $this->entityManager->persist($glossaryEntry);
            $this->entityManager->flush();
            return true;
        }

        return false;
    }

    /**
     * Finds entry by given term.
     *
     * @param string $term
     *
     * @return ?GlossaryEntry
     */
    public function findEntry(string $term): ?GlossaryEntry
    {
        return $this->glossaryRepository->findByTerm($term);
    }

    /**
     * Updates existing entry.
     *
     * @param GlossaryEntry $glossaryEntry
     *
     * @return bool
     */
    public function updateEntry(GlossaryEntry $glossaryEntry): bool
    {
        if ($this->findEntry($glossaryEntry->getTerm()) !== null) {
            $this->entityManager->persist($glossaryEntry);
            $this->entityManager->flush();
            return true;
        }

        return false;
    }

    /**
     * Deletes existing entry.
     *
     * @param GlossaryEntry $glossaryEntry
     *
     * @return bool
     */
    public function deleteEntry(GlossaryEntry $glossaryEntry): bool
    {
        if ($this->findEntry($glossaryEntry->getTerm()) !== null) {
            $this->entityManager->remove($glossaryEntry);
            $this->entityManager->flush();
            return true;
        }

        return false;
    }
}
