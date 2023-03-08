<?php

namespace App\Entity;

use App\Repository\HospitalisationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Mime\Message;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HospitalisationRepository::class)]
class Hospitalisation
{
     

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"AUTO")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message:"date  is required")]
    private ?\DateTimeInterface $DateEntree = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message:"date  is required")]
    #[Assert\GreaterThanOrEqual(propertyPath:"dateEntree", message:"La date de sortie doit être postérieure ou égale à la date d'entrée")]
    private ?\DateTimeInterface $DateSortie = null;

  

    #[ORM\Column]
    #[Assert\NotNull(message:"id   is required")]
    #[Assert\Regex(pattern:"/^\d+(\.\d{1,2})?$/", message:"Price must be a valid decimal number")]
    private ?int $idHospitalisation = null;

    #[ORM\ManyToOne(inversedBy: 'hospitalisations')]
    #[Assert\NotBlank(message:"service  is required")]
    private ?Services $service = null;

  

    
  

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEntree(): ?\DateTimeInterface
    {
        return $this->DateEntree;
    }

    public function setDateEntree(\DateTimeInterface $DateEntree): self
    {
        $this->DateEntree = $DateEntree;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->DateSortie;
    }

    public function setDateSortie(\DateTimeInterface $DateSortie): self
    {
        $this->DateSortie = $DateSortie;

        return $this;
    }

   

    public function getIdHospitalisation(): ?int
    {
        return $this->idHospitalisation;
    }

    public function setIdHospitalisation(int $idHospitalisation): self
    {
        $this->idHospitalisation = $idHospitalisation;

        return $this;
    }

    public function getService(): ?Services
    {
        return $this->service;
    }

    public function setService(?Services $service): self
    {
        $this->service = $service;

        return $this;
    }

   



  
    
}
