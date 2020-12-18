<?php

namespace App\Service;

use App\Repository\GlossaryRepository;

class CsvExportService extends AbstractExportService implements CsvExportServiceInterface
{
    public const COLUM1 = 'ID';
    public const COLUM2 = 'Term';
    public const COLUM3 = 'Description';
    public const COLUM4 = 'Relevance';
    public const COLUM5 = 'Creation Date';
    public const COLUM6 = 'Change Date';
    private const DELIMITER_DEFAULT = 'x';
    private const ENCLOSURE_DEFAULT = '"';
    private const FORMAT_DEFAULT = 'Y-m-d H:i:s';
    private $delimiter = '';
    private $enclosure = '';
    private $format = '';

    public function __construct(
        string $delimiter = '',
        string $enclosure = '',
        string $format = ''
    ) {
        $this->delimiter = $delimiter ?: self::DELIMITER_DEFAULT;
        $this->enclosure = $enclosure ?: self::ENCLOSURE_DEFAULT;
        $this->format = $format ?: self::FORMAT_DEFAULT;
    }

    public function createCsvFile(
        GlossaryRepository $glossaryRepo //auch über constructor?
    ) {
        $csvFile = fopen('glossary.csv', 'w');
        $entries = $glossaryRepo->findAll();

        $this->writeCsvHeader($csvFile);
        $this->writeCsvData($entries, $csvFile);
        rewind($csvFile);

        return $csvFile;
    }

    public function writeCsvHeader($csvFile): void
    {
        fputcsv($csvFile, [
            self::COLUM1,
            self::COLUM2,
            self::COLUM3,
            self::COLUM4,
            self::COLUM5,
            self::COLUM6
        ], $this->delimiter, $this->enclosure);
    }

    public function writeCsvData($entries, $csvFile): void
    {
        foreach ($entries as $entry) {
            $data = [
                $entry->getId(),
                $entry->getTerm(),
                $entry->getDescription(),
                $entry->getRelevance(),
                $entry->getCreationDate()->format($this->format),
                $entry->getChangeDate()->format($this->format),
            ];

            fputcsv($csvFile, $data, $this->delimiter, $this->enclosure);
        }
    }
}
