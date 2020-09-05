<?php

namespace App\Entity;

use App\Repository\GlossaryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ORM\Entity(repositoryClass=GlossaryRepository::class)
* @UniqueEntity("id")
*/
class GlossaryEntry
{
    /**
    * @ORM\Id()
    * @ORM\GeneratedValue()
    * @ORM\Column(type="integer", unique=true)
    */
    private $id;

    /**
    * @ORM\Column(type="string", length=160, unique=true)
    */
    private $term;

    /**
    * @ORM\Column(type="text")
    */
    private $description;

    /**
    * @ORM\Column(type="integer")
    */
    private $relevance;

    /**
    * @ORM\Column(type="datetime", options={"default" = "CURRENT_TIMESTAMP"})
    */
    private $creationDate;

    /**
    * @ORM\Column(type="datetime", columnDefinition="DATETIME on update CURRENT_TIMESTAMP")
    */
    private $changeDate;

    public function __construct()
    {
        $this->creationDate = new \DateTime();
        $this->changeDate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTerm(): ?string
    {
        return $this->term;
    }

    public function setTerm(string $term): self
    {
        $this->term = $term;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRelevance(): ?int
    {
        return $this->relevance;
    }

    public function setRelevance(int $relevance): self
    {
        $this->relevance = $relevance;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getChangeDate(): ?\DateTimeInterface
    {
        return $this->changeDate;
    }

    public function setChangeDate(\DateTimeInterface $changeDate): self
    {
        $this->changeDate = $changeDate;

        return $this;
    }
}
