<?php
//
// Entité "Programme", fournissant la classe de base ainsi que ses getters/setters des attributs privés de la classe.
//
// L'entité "Programme" est créée uniquement pour gérer la relation "ManyToMany" entre les entités "Session" et "Module", 
// relation nécessitant un attribut de caractérisation complémentaire "durée".
//

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgrammeRepository")
 * @ORM\Table(name="programme",
 *            uniqueConstraints={
 *                               @ORM\UniqueConstraint(name="programme_unique", columns={"module_id", "session_id"})
 *                              }
 *           )
 */
class Programme
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Session", inversedBy="programmes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $session;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Module", inversedBy="programmes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $module;

    public function __toString(): string
    {
        return $this->getCategorieModule();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): self
    {
        $this->session = $session;

        return $this;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): self
    {
        $this->module = $module;

        return $this;
    }

    public function getCategorieModule(): ?string
    {
        return $this->module->getCategorieLibelle();
    }
}
