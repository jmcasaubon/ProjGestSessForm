<?php

namespace App\Entity;

use DateTime;
use App\Entity\Programme;
use App\Entity\Stagiaire;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SessionRepository")
 */
class Session
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=127)
     */
    private $intitule;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     * @Assert\Expression("this.getDateDebut() < this.getDateFin()", message="La date d'achèvement doit être postérieure à la date de démarrage !")
     */
    private $dateFin;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPlaces;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Programme", mappedBy="session", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"module" = "ASC"})
     */
    private $programmes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Stagiaire", inversedBy="sessions")
     * @ORM\OrderBy({"nom" = "ASC", "prenom" = "ASC"})
     */
    private $stagiaires;

    public function __construct()
    {
        $this->programmes = new ArrayCollection();
        $this->stagiaires = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        return $this->intitule;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getNbPlaces(): ?int
    {
        return $this->nbPlaces;
    }

    public function setNbPlaces(int $nbPlaces): self
    {
        $this->nbPlaces = $nbPlaces;

        return $this;
    }

    /**
     * @return Collection|Programme[]
     */
    public function getProgrammes(): Collection
    {
        return $this->programmes;
    }

    public function addProgramme(Programme $programme): self
    {
        if (!$this->programmes->contains($programme)) {
            $this->programmes[] = $programme;
            $programme->setSession($this);
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): self
    {
        if ($this->programmes->contains($programme)) {
            $this->programmes->removeElement($programme);
            // set the owning side to null (unless already changed)
            if ($programme->getSession() === $this) {
                $programme->setSession(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Stagiaire[]
     */
    public function getStagiaires(): Collection
    {
        return $this->stagiaires;
    }

    public function addStagiaire(Stagiaire $stagiaire): self
    {
        if (!$this->stagiaires->contains($stagiaire)) {
            $this->stagiaires[] = $stagiaire;
        }

        return $this;
    }

    public function removeStagiaire(Stagiaire $stagiaire): self
    {
        if ($this->stagiaires->contains($stagiaire)) {
            $this->stagiaires->removeElement($stagiaire);
        }

        return $this;
    }

    public function getDuree(): ?int
    {
        $duree = 0 ;
        foreach ($this->programmes as $programme) {
            $duree += $programme->getDuree() ;
        }
        return $duree;
    }

    public function getNbStagiaires(): ?int
    {
        return count($this->stagiaires);
    }

    public function getNbModules(): ?int
    {
        return count($this->programmes);
    }

    public function getFuture(): ?bool 
    {
        $now = new DateTime("NOW") ;

        return ($now < $this->getDateDebut());
    }


    public function getVerrou(): ?bool 
    {
        $now = new DateTime("NOW") ;

        return (($now >= $this->getDateDebut()) || ($this->getNbStagiaires() > 0));
    }
}
