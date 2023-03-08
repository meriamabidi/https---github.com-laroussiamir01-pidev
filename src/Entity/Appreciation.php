<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use App\Repository\AppreciationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppreciationRepository::class)]
class Appreciation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message:"message is required")]
    private ?string $message = null;

    #[ORM\ManyToOne(inversedBy: 'appreciations')]
    #[Assert\NotBlank(message:"subject is required")]
    private ?Services $sujet = null;

    #[ORM\Column(length: 50)]
    
    private ?string $auteur = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message:"dATE is required")]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"THIS  is required")]
    private ?int $nbOccurences = null;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getSujet(): ?Services
    {
        return $this->sujet;
    }

    public function setSujet(?Services $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getNbOccurences(): ?int
    {
        return $this->nbOccurences;
    }

    public function setNbOccurences(int $nbOccurences): self
    {
        $this->nbOccurences = $nbOccurences;

        return $this;
    }
}
