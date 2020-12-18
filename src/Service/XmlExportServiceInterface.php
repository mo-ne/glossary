<?php

namespace App\Service;

use App\Repository\GlossaryRepository;
use Symfony\Component\HttpFoundation\Response;

interface XmlExportServiceInterface
{
    public function serializeEntriesAsXml(): string;

    public function createExportResponseObject(
        $content,
        string $fileName,
        string $contentType
    ): Response;
}
