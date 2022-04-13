<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Exercices
 *
 * @ORM\Table(name="exercices", indexes={@ORM\Index(name="ID_crs", columns={"ID_crs"})})
 * @ORM\Entity
 */
class Exercices
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_ex", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEx;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=250, nullable=false)
     * @Assert\NotBlank(message="Veuillez Choisir un Type")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="Question", type="string", length=250, nullable=false)
     * @Assert\NotBlank(message="Veuillez Saisir une question")
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(name="Reponse", type="string", length=250, nullable=false)
     * @Assert\NotBlank(message="Veuillez Saisir une réponse")
     */
    private $reponse;

    /**
     * @var string
     *
     * @ORM\Column(name="Hint", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez Saisir une hint")
     */
    private $hint;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez Téleverser une image")
     */
    private $image;

    /**
     * @var \Cours
     *
     * @ORM\ManyToOne(targetEntity="Cours")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_crs", referencedColumnName="ID_crs")
     * })
     */
    private $idCrs;

    public function getIdEx(): ?int
    {
        return $this->idEx;
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

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(?string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(?string $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getHint(): ?string
    {
        return $this->hint;
    }

    public function setHint(?string $hint): self
    {
        $this->hint = $hint;

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

    public function getIdCrs(): ?Cours
    {
        return $this->idCrs;
    }

    public function setIdCrs(?Cours $idCrs): self
    {
        $this->idCrs = $idCrs;

        return $this;
    }
  


}
