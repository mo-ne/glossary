<?php

namespace App\Service;

use App\Repository\GlossaryRepository;
use Symfony\Component\HttpFoundation\Response;

interface CsvExportServiceInterface
{
    public function createCsvFile(
        GlossaryRepository $glossaryRepo
    );

    public function createExportResponseObject(
        $content,
        string $fileName,
        string $contentType
    ): Response;
}
