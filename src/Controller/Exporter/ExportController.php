<?php

namespace App\Controller\Exporter;

use App\Repository\GlossaryRepository;
use App\Service\CsvExportServiceInterface;
use App\Service\XmlExportServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ExportController extends AbstractController
{
    /**
     * Renders Exporter.
     *
     * @return Response
     */
    public function export(): Response
    {
        return $this->render('Glossary/export.html.twig');
    }

    /**
     * Gets Entries as CSV from CsvExportService and creates downloadable CSV file.
     *
     * @param CsvExportServiceInterface $exporter
     * @param GlossaryRepository $glossaryRepo
     *
     * @return Response
     */
    public function exportCsv(
        CsvExportServiceInterface $exporter,
        GlossaryRepository $glossaryRepo
    ): Response {
        $csvFile = $exporter->createCsvFile($glossaryRepo);
        $csv = file_get_contents('glossary.csv');
        $fileName = 'glossary.csv';
        $contentType = 'text/csv';

        $response = $exporter->createExportResponseObject(
            $csv,
            $fileName,
            $contentType
        );
        fclose($csvFile);

        return $response;
    }

    /**
     * Gets serialized Entries from XmlExportService and creates downloadable file.
     *
     * @param XmlExportServiceInterface $exporter
     * @param GlossaryRepository $glossaryRepo
     *
     * @return Response
     */
    public function exportXml(
        XmlExportServiceInterface $exporter,
        GlossaryRepository $glossaryRepo
    ): Response {
        $xml = $exporter->serializeEntriesAsXml();
        $fileName = 'glossary.xml';
        $contentType = 'text/xml';

        $response = $exporter->createExportResponseObject(
            $xml,
            $fileName,
            $contentType
        );

        return $response;
    }
}
