<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cours
 *
 * @ORM\Table(name="cours", indexes={@ORM\Index(name="Id_g", columns={"ID_g"})})
 * @ORM\Entity
 */
class Cours
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_crs", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCrs;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=250, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="Titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="Contenu", type="text", length=65535, nullable=false)
     */
    private $contenu;

    /**
     * @var \Guide
     *
     * @ORM\ManyToOne(targetEntity="Guide")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_g", referencedColumnName="ID_g")
     * })
     */
    private $idG;

    public function getIdCrs(): ?int
    {
        return $this->idCrs;
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

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getIdG(): ?Guide
    {
        return $this->idG;
    }

    public function setIdG(?Guide $idG): self
    {
        $this->idG = $idG;

        return $this;
    }


}