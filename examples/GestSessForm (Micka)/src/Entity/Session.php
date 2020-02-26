<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string", length=100)
     */
    private $intituleSession;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateFin;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPlaces;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SessionModule", mappedBy="session")
     */
    private $sessionModules;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Stagiaire", mappedBy="sessions")
     * @ORM\OrderBy({"nomStagiaire" = "ASC"})
     */
    private $stagiaires;

    public function __construct()
    {
        $this->sessionModules = new ArrayCollection();
        $this->stagiaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntituleSession(): ?string
    {
        return $this->intituleSession;
    }

    public function setIntituleSession(string $intituleSession): self
    {
        $this->intituleSession = $intituleSession;

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
     * @return Collection|SessionModule[]
     */
    public function getSessionModules(): Collection
    {
        return $this->sessionModules;
    }

    public function addSessionModule(SessionModule $sessionModule): self
    {
        if (!$this->sessionModules->contains($sessionModule)) {
            $this->sessionModules[] = $sessionModule;
            $sessionModule->setSession($this);
        }

        return $this;
    }

    public function removeSessionModule(SessionModule $sessionModule): self
    {
        if ($this->sessionModules->contains($sessionModule)) {
            $this->sessionModules->removeElement($sessionModule);
            // set the owning side to null (unless already changed)
            if ($sessionModule->getSession() === $this) {
                $sessionModule->setSession(null);
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
            $stagiaire->addSession($this);
        }

        return $this;
    }

    public function removeStagiaire(Stagiaire $stagiaire): self
    {
        if ($this->stagiaires->contains($stagiaire)) {
            $this->stagiaires->removeElement($stagiaire);
            $stagiaire->removeSession($this);
        }

        return $this;
    }
}
