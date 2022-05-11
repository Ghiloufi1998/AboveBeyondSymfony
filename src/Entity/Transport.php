<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; 


/**
 * Transport
 *
 * @ORM\Table(name="transport", indexes={@ORM\Index(name="transport_ibfk_1", columns={"Hebergement_id"})})
 * @ORM\Entity
 */
class Transport
{
    /**
     * @var int
     *
     * @ORM\Column(name="Transport_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $transportId;

    /**
     * @Assert\NotBlank(message="Champ type vide ! ")
     * @var string
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Veuillez saisir une chaine pas d'entiers"
     * )
     * Assert\Length(
     *      min = 3,
     *      max = 12,
     *   minMessage = "min error ",
     *   maxMessage = "max error "
     *   )
     *
     * @ORM\Column(name="Type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @Assert\NotBlank(message="Champ description vide ! ")
     * @var string
     *@ Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Veuillez saisir une chaine pas d'entiers"
     * )
     *
     * @ORM\Column(name="Description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @Assert\NotBlank(message="Champ Disponibilite vide ! ")
     * @var int
     * @Assert\Expression(" this.getDisponibilite()==1 || this.getDisponibilite()==0  ",message="Dispo 0 ou 1 ")
     *
     * @ORM\Column(name="Disponibilite", type="integer", nullable=false)
     */
    private $Disponibilite;

    /**
     * @Assert\NotBlank(message="Champ prix vide ! ")
     * @var int
     *@Assert\Positive(message="Le prix doit etre positif ! ")
     * @ORM\Column(name="Prix", type="integer", nullable=false)
     */
    private $prix;

    /**
     * @Assert\NotBlank(message="Champ image vide ! ")
     * @var string
     *
     * Assert\Length(
     *      min = 5,
     *      max = 50,
     *   minMessage = "min error ",
     *   maxMessage = "max error "
     *   )
     *
     * @ORM\Column(name="Image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @Assert\NotBlank(message="Veuillez saisir l'hebergemnt adéquat ! ")
     * @var \Hebergement
     *
     * @ORM\ManyToOne(targetEntity="Hebergement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Hebergement_id", referencedColumnName="Hebergement_id")
     * })
     */
    private $hebergement;

    public function getTransportId(): ?int
    {
        return $this->transportId;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDisponibilite(): ?int
    {
        return $this->Disponibilite;
    }

    public function setDisponibilite(int $Disponibilite): self
    {
        $this->Disponibilite  = $Disponibilite;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getHebergement(): ?Hebergement
    {
        return $this->hebergement;
    }

    public function setHebergement(?Hebergement $hebergement): self
    {
        $this->hebergement = $hebergement;

        return $this;
    }


}
