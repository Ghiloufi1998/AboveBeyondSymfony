<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Guide
 *
 * @ORM\Table(name="guide", indexes={@ORM\Index(name="id_vol", columns={"id_vol"})})
 * @ORM\Entity
 */
class Guide
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_g", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idG;

    /**
     * @var string
     *
     * @ORM\Column(name="Titre", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez Choisir un titre")
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Veuillez remplir avec des caratéres"
     * )
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="Pays", type="string", length=250, nullable=false)
     * @Assert\NotBlank(message="Veuillez Choisir un Pays")
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Veuillez remplir avec des caratéres"
     * )
     */
    private $pays;

    /**
     * @var int
     *
     * @ORM\Column(name="Level", type="integer", nullable=false)
     * @Assert\Range(
     *      min = 1,
     *      max = 5,
     *      notInRangeMessage = "Veuillez Choisir un Niveau entre {{ min }} et {{ max }} ",
     * )
     * @Assert\NotBlank(message="Veuillez Saisir un Niveau")
     */
    private $level;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez Téleverser une image")
     * 
     */
    private $image;

    /**
     * @var \Vol
     *
     * @ORM\ManyToOne(targetEntity="Vol")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_vol", referencedColumnName="Vol_id")
     * })
     */
    private $idVol;
   
    public function getIdG(): ?int
    {
        return $this->idG;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(?int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getIdVol(): ?Vol
    {
        return $this->idVol;
    }

    public function setIdVol(?Vol $idVol): self
    {
        $this->idVol = $idVol;

        return $this;
    }
    public function __toString() {
        return $this->titre;
    }
}
