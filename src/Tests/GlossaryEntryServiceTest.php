<?php

namespace App\Tests;

use App\Entity\GlossaryEntry;
use App\Model\GlossaryEntryService;
use App\Repository\GlossaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class GlossaryEntryServiceTest extends TestCase
{
    public function testFindEntry()
    {
        $glossaryEntry = new GlossaryEntry();
        $glossaryEntry->setTerm('Pandi');
        $glossaryEntry->setDescription('sweet');

        $glossaryRepository1 = $this->createMock(GlossaryRepository::class);
        $glossaryRepository1
            ->expects($this->any())
            ->method('findByTerm')
            ->willReturn($glossaryEntry);

        $glossaryRepository2 = $this->createMock(GlossaryRepository::class);
        $glossaryRepository2
            ->expects($this->any())
            ->method('findByTerm')
            ->willReturn(null);

        $manager1 = $this->createMock(EntityManagerInterface::class);
        $manager1
            ->expects($this->any())
            ->method('getRepository')
            ->willReturn($glossaryRepository1);

        $manager2 = $this->createMock(EntityManagerInterface::class);
        $manager2
            ->expects($this->any())
            ->method('getRepository')
            ->willReturn($glossaryRepository2);

        $glossaryEntryService1 = new GlossaryEntryService($glossaryRepository1, $manager1);
        $this->assertEquals($glossaryEntry, $glossaryEntryService1->findEntry('Pandi'));

        $glossaryEntryService2 = new GlossaryEntryService($glossaryRepository2, $manager2);
        $this->assertNotEquals($glossaryEntry, $glossaryEntryService2->findEntry('Friedrich'));
    }

    public function testInsertEntry()
    {
        $glossaryEntry = new GlossaryEntry();
        $glossaryEntry->setTerm('Pandi');
        $glossaryEntry->setDescription('sweet');

        $glossaryRepository = $this->createMock(GlossaryRepository::class);
        $glossaryRepository
            ->expects($this->any())
            ->method('findByTerm')
            ->willReturn(null);

        $manager = $this->createMock(EntityManagerInterface::class);
        $manager
            ->expects($this->any())
            ->method('getRepository')
            ->willReturn($glossaryRepository);


        $glossaryEntryService = new GlossaryEntryService($glossaryRepository, $manager);
        $this->assertTrue($glossaryEntryService->insertEntry($glossaryEntry));
    }

    public function testUpdateEntry()
    {
        $glossaryEntry = new GlossaryEntry();
        $glossaryEntry->setTerm('Pandi');
        $glossaryEntry->setDescription('sweet');

        $glossaryRepository = $this->createMock(GlossaryRepository::class);
        $glossaryRepository
            ->expects($this->any())
            ->method('findByTerm')
            ->willReturn($glossaryEntry);

        $manager = $this->createMock(EntityManagerInterface::class);
        $manager
            ->expects($this->any())
            ->method('getRepository')
            ->willReturn($glossaryRepository);


        $glossaryEntryService = new GlossaryEntryService($glossaryRepository, $manager);
        $this->assertTrue($glossaryEntryService->updateEntry($glossaryEntry));
    }
}
