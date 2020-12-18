<?php

namespace App\Tests;

use App\Entity\GlossaryEntry;
use App\Repository\GlossaryRepository;
use App\Service\XmlExportService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Response;

class XmlExportServiceTest extends TestCase
{
    public function setUp()
    {
        $glossaryEntry = new GlossaryEntry();
        $glossaryEntry->setTerm('Pandi');
        $glossaryEntry->setDescription('sweet');

        $glossaryRepository = $this->createMock(GlossaryRepository::class);
        $glossaryRepository
           ->expects($this->any())
           ->method('findAll')
           ->willReturn($glossaryEntry);

        $xmlExporter = new XmlExportService($glossaryRepository);
        $xml = $xmlExporter->serializeEntriesAsXml();

        $this->xml = $xml;
        $this->glossaryRepository = $glossaryRepository;
        $this->glossaryEntry = $glossaryEntry;
    }

    public function testSerializeEntriesAsXml()
    {
        $xmlExporter = new XmlExportService($this->glossaryRepository);

        $xmlObject = simplexml_load_string(
            $this->xml,
            null,
            LIBXML_NOCDATA
        );

        $this->assertNotFalse($xmlObject);
        $this->assertInstanceOf(\SimpleXMLElement::class, $xmlObject);

        $this->assertObjectHasAttribute('term', $xmlObject);
        $this->assertObjectHasAttribute('description', $xmlObject);
        $this->assertObjectNotHasAttribute('Pandi', $xmlObject);
    }

    public function testCreateExportResponseObject()
    {
        $xmlExporter = new XmlExportService($this->glossaryRepository);

        $content = $this->xml;
        $fileName = 'glossary.xml';
        $contentType = 'text/xml';

        $response = $xmlExporter->createExportResponseObject(
            $content,
            $fileName,
            $contentType
        );

        $this->assertObjectHasAttribute('headers', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Pandi', $response->getContent());
        $this->assertStringContainsString('sweet', $response->getContent());
        $this->assertStringNotContainsString('no content', $response->getContent());
    }
}
