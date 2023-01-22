<?php
//
// Entité "Session", fournissant la classe de base ainsi que ses getters/setters des attributs privés de la classe.
//
// Quelques méthodes personnalisées sont ajoutées en fin de fichier.
//

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
     */
    private $dateFin;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPlaces;

    private $nbPlacesRestantes;

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
        $this->nbPlacesRestantes = $this->nbPlaces;
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

    public function getNbPlacesRestantes(): ?int
    {
        return $this->nbPlacesRestantes;
    }

    public function setNbPlacesRestantes($nbPlacesRestantes): self
    {
        $this->nbPlacesRestantes = $nbPlacesRestantes;

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
            $this->nbPlacesRestantes--;
        }

        return $this;
    }

    public function removeStagiaire(Stagiaire $stagiaire): self
    {
        if ($this->stagiaires->contains($stagiaire)) {
            $this->stagiaires->removeElement($stagiaire);
            $this->nbPlacesRestantes++;
        }

        return $this;
    }

    //
    // Méthodes personnalisées
    //

    public function __toString(): string
    {
        return $this->intitule;
    }

    public function getDuree(): ?int
    {
        $duree = 0 ;
        foreach ($this->programmes as $programme) {
            $duree += $programme->getDuree() ;
        }
        return $duree;
    }

    public function getNbJoursOuvres(): ?int
    {
        $duree = 0 ;

        $jrD = $this->getDateDebut()->format("z") ;
        $jrF = $this->getDateFin()->format("z") ;

        $anD = $this->getDateDebut()->format("Y") ;
        $anF = $this->getDateFin()->format("Y") ;

        $an = $anD ;
        // Pour chaque année couverte par la session de formation ...
        do {
            // Quantième de la date de Pâques de l'année en cours (permettra de trouver les jours fériés mobiles)
            $noJP = easter_days($an) + date("z", mktime(0, 0, 0, 31, 3, $an));

            // Quantièmes du premier jour et du dernier jour à prendre en compte dans l'année en cours 
            $noJD = ($an == $anD) ? $jrD : 0 ;
            $noJF = ($an == $anF) ? $jrF : date("z", mktime(0, 0, 0, 31, 12, $an)) ;

            // Construction d'un tableau des jours fériés (en Alsace !)
            $tblF = array(
                // Dates fixes
                date("z", mktime(0, 0, 0, 1, 1, $an)),      // Jour de l'An
                date("z", mktime(0, 0, 0, 5, 1, $an)),      // Fête du travail
                date("z", mktime(0, 0, 0, 5, 8, $an)),      // Victoire 1945
                date("z", mktime(0, 0, 0, 7, 14, $an)),     // Fête Nationale
                date("z", mktime(0, 0, 0, 8, 15, $an)),     // Assomption
                date("z", mktime(0, 0, 0, 11, 1, $an)),     // Toussaint
                date("z", mktime(0, 0, 0, 11, 11, $an)),    // Victoire 1918
                date("z", mktime(0, 0, 0, 12, 25, $an)),    // Noël
                date("z", mktime(0, 0, 0, 12, 26, $an)),    // Lendemain de Noël
                // Fêtes mobiles (basées sur la date de Pâques)
                $noJP - 2,                                  // Vendredi Saint
                $noJP + 1,                                  // Lundi de Pâques
                $noJP + 39,                                 // Jeudi de l'Ascension
                $noJP + 50,                                 // Lundi de Pentecôte
            ) ;

            // Pour tous les jours de l'année en cours, situés entre les jours de début et de fin ...
            for ($j = $noJD ; $j <= $noJF ; $j++) {
                $typJ = date("w", (mktime(0, 0, 0, 1, 1, $an) + ($j * (24 * 60 * 60)))) ;

                // ... on ne compte '+ 1' que si le jour n'est ni un dimanche, ni un samedi, ni un jour férié.
                $duree += ((($typJ == 0) || ($typJ == 6)) || in_array($j, $tblF)) ? 0 : 1 ;
            }

            $an++ ;
        } while ($an < $anF) ;

        return $duree;
    }

    public function getNbStagiaires(): ?int
    {
        return count($this->stagiaires);
    }

    public function getNbPlacesLibres(): ?int
    {
        $this->setNbPlacesRestantes($this->getNbPlaces() - $this->getNbStagiaires());
        return $this->getNbPlacesRestantes() ;
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
