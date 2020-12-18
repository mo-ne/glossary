<?php

namespace App\Service;

use App\Entity\GlossaryEntry;
use App\Repository\GlossaryRepository;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class XmlExportService extends AbstractExportService implements XmlExportServiceInterface
{
    /**
     * @var ?GlossaryRepository
     */
    private $glossaryRepo = null;

    public function __construct(GlossaryRepository $glossaryRepo)
    {
        $this->glossaryRepo = $glossaryRepo;
    }

    public function serializeEntriesAsXml(): string
    {
        $entries = $this->glossaryRepo->findAll();
        $serializer = SerializerBuilder::create()->build();
        $xml = $serializer->serialize($entries, 'xml');

        return $xml;
    }
}
