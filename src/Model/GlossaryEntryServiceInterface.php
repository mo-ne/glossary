<?php

namespace App\Model;

use App\Entity\GlossaryEntry;

interface GlossaryEntryServiceInterface
{
    /**
     * Inserts new entry.
     *
     * @param GlossaryEntry $glossaryEntry
     *
     * @return bool
     */
    public function insertEntry(GlossaryEntry $glossaryEntry): bool;

    /**
     * Finds entry by given term.
     *
     * @param string $term
     *
     * @return ?GlossaryEntry
     */
    public function findEntry(string $term): ?GlossaryEntry;

    /**
     * Updates existing entry.
     *
     * @param GlossaryEntry $glossaryEntry
     *
     * @return bool
     */
    public function updateEntry(GlossaryEntry $glossaryEntry): bool;

    /**
     * Deletes existing entry.
     *
     * @param GlossaryEntry $glossaryEntry
     *
     * @return bool
     */
    public function deleteEntry(GlossaryEntry $glossaryEntry): bool;
}
