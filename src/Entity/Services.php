<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\ServicesRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ServicesRepository::class)]
class Services
{

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"AUTO")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message:"Type is required")]
    private ?string $type = null;
    

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Description is required")]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Chef service is required")]
    private ?string $Chef_service = null;

    #[ORM\Column]
    #[Assert\Regex(pattern:"/^\d+(\.\d{1,2})?$/", message:"Price must be a valid decimal number")]
    #[Assert\NotNull(message:"prix is required")]
    private ?float $prix = null;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: Hospitalisation::class, orphanRemoval:true)]
    private Collection $hospitalisations;

    #[ORM\OneToMany(mappedBy: 'sujet', targetEntity: Appreciation::class,orphanRemoval:true)]
    private Collection $appreciations;

   

   

    public function __construct()
    {
        $this->hospitalisations = new ArrayCollection();
        $this->appreciations = new ArrayCollection();
      
        
    }

   

   
    


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getChefService(): ?string
    {
        return $this->Chef_service;
    }

    public function setChefService(string $Chef_service): self
    {
        $this->Chef_service = $Chef_service;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, Hospitalisation>
     */
    public function getHospitalisations(): Collection
    {
        return $this->hospitalisations;
    }

    public function addHospitalisation(Hospitalisation $hospitalisation): self
    {
        if (!$this->hospitalisations->contains($hospitalisation)) {
            $this->hospitalisations->add($hospitalisation);
            $hospitalisation->setService($this);
        }

        return $this;
    }

    public function removeHospitalisation(Hospitalisation $hospitalisation): self
    {
        if ($this->hospitalisations->removeElement($hospitalisation)) {
            // set the owning side to null (unless already changed)
            if ($hospitalisation->getService() === $this) {
                $hospitalisation->setService(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->type;
    }

    /**
     * @return Collection<int, Appreciation>
     */
    public function getAppreciations(): Collection
    {
        return $this->appreciations;
    }

    public function addAppreciation(Appreciation $appreciation): self
    {
        if (!$this->appreciations->contains($appreciation)) {
            $this->appreciations->add($appreciation);
            $appreciation->setSujet($this);
        }

        return $this;
    }

    public function removeAppreciation(Appreciation $appreciation): self
    {
        if ($this->appreciations->removeElement($appreciation)) {
            // set the owning side to null (unless already changed)
            if ($appreciation->getSujet() === $this) {
                $appreciation->setSujet(null);
            }
        }

        return $this;
    }

}