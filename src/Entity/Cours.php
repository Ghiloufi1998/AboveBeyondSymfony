<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
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
     * @Groups("post:read")
     */
    private $idCrs;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=250, nullable=false)
     * @Groups("post:read")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="Titre", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez Saisir un titre")
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Veuillez Saisir une Chaine"
     * )
     * @Groups("post:read")
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="Contenu", type="text", length=65535, nullable=false)
     * @Assert\NotBlank(message="Veuillez Saisir un Contenu")
     * @Groups("post:read")
     */
    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez Téleverser une image")
     * @Groups("post:read")
     *
     */
    private $image;

    /**
     * @var \Guide
     *
     * @ORM\ManyToOne(targetEntity="Guide")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_g", referencedColumnName="ID_g")
     * })
     * @Groups("post:read")
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

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
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

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

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

    public function getIdG(): ?Guide
    {
        return $this->idG;
    }

    public function setIdG(?Guide $idG): self
    {
        $this->idG = $idG;

        return $this;
    }
    public function __toString() {
        return $this->titre;
    }



}
