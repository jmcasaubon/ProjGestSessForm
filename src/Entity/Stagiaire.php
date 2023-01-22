<?php
//
// Entité "Stagiaire", fournissant la classe de base ainsi que ses getters/setters des attributs privés de la classe.
//
// Quelques méthodes personnalisées sont ajoutées en fin de fichier.
//

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @ORM\Column(type="string", length=63)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=63)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private $sexe;

    /**
     * @ORM\Column(type="date")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $cpostal;

    /**
     * @ORM\Column(type="string", length=63, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=23, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $mail;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Session", mappedBy="stagiaires")
     * @ORM\OrderBy({"dateDebut" = "ASC", "dateFin" = "ASC"})
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

    public function getNom(): ?string
    {
        return (mb_strtoupper($this->nom));
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return ucwords($this->prenom, "-_ \t\r\n\f\v");
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCpostal(): ?string
    {
        return $this->cpostal;
    }

    public function setCpostal(?string $cpostal): self
    {
        $this->cpostal = $cpostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

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
            $session->addStagiaire($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->contains($session)) {
            $this->sessions->removeElement($session);
            $session->removeStagiaire($this);
        }

        return $this;
    }
    
    //
    // Méthodes personnalisées
    //

    public function __toString(): string
    {
        return $this->getNomPrenom();
    }

    public function getNomPrenom(): ?string
    {
        return ($this->getNom().' '.$this->getPrenom());
    }
    public function getAge(): ?int
    {
        $now = new DateTime("NOW") ;
        return $now->diff($this->dateNaissance)->y ;
    }

    public function getNbSessionsSuivies(): ?int
    {
        return count($this->sessions) ;
    }

    public function getNbSessionsFutures(): ?int
    {
        $now = new DateTime("NOW") ;
        $nbsess = 0 ;
        foreach ($this->sessions as $session) {
            $nbsess += ($now < $session->getDateDebut()) ? 1 : 0 ;
        }
        return $nbsess ;
    }

    public function getNbSessionsEnCours(): ?int
    {
        $now = new DateTime("NOW") ;
        $nbsess = 0 ;
        foreach ($this->sessions as $session) {
            $nbsess += (($now >= $session->getDateDebut()) && ($now <= $session->getDateFin())) ? 1 : 0 ;
        }
        return $nbsess ;
    }

    public function getNbSessionsAchevees(): ?int
    {
        $now = new DateTime("NOW") ;
        $nbsess = 0 ;
        foreach ($this->sessions as $session) {
            $nbsess += ($now > $session->getDateFin()) ? 1 : 0 ;
        }
        return $nbsess ;
    }
}
