<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StagiaireRepository")
 */
class Stagiaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nomStagiaire;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenomStagiaire;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $sexeStagiaire;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $mailStagiaire;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $telStagiaire;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $villeStagiaire;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Session", inversedBy="stagiaires")
     * @ORM\OrderBy({"dateDebut" = "ASC"})
     */
    private $sessions;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomStagiaire(): ?string
    {
        return $this->nomStagiaire;
    }

    public function setNomStagiaire(string $nomStagiaire): self
    {
        $this->nomStagiaire = $nomStagiaire;

        return $this;
    }

    public function getPrenomStagiaire(): ?string
    {
        return $this->prenomStagiaire;
    }

    public function setPrenomStagiaire(string $prenomStagiaire): self
    {
        $this->prenomStagiaire = $prenomStagiaire;

        return $this;
    }

    public function getSexeStagiaire(): ?string
    {
        return $this->sexeStagiaire;
    }

    public function setSexeStagiaire(string $sexeStagiaire): self
    {
        $this->sexeStagiaire = $sexeStagiaire;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getMailStagiaire(): ?string
    {
        return $this->mailStagiaire;
    }

    public function setMailStagiaire(string $mailStagiaire): self
    {
        $this->mailStagiaire = $mailStagiaire;

        return $this;
    }

    public function getTelStagiaire(): ?string
    {
        return $this->telStagiaire;
    }

    public function setTelStagiaire(?string $telStagiaire): self
    {
        $this->telStagiaire = $telStagiaire;

        return $this;
    }

    public function getVilleStagiaire(): ?string
    {
        return $this->villeStagiaire;
    }

    public function setVilleStagiaire(?string $villeStagiaire): self
    {
        $this->villeStagiaire = $villeStagiaire;

        return $this;
    }

    /**
     * @return Collection|Session[]
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->contains($session)) {
            $this->sessions->removeElement($session);
        }

        return $this;
    }

    public function __toString(){
        return $this->getNomStagiaire()." ".$this->getPrenomStagiaire();
    }

    public function getAge(){
        $today = new \DateTime();
        return $this->dateNaissance->diff($today)->format("%Y");
    }
}

