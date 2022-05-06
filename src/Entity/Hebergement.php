<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; 
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Hebergement
 *
 * @ORM\Table(name="hebergement")
 * @ORM\Entity
 */
class Hebergement
{
    /**
     * @var int
     *
     * @ORM\Column(name="Hebergement_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")
     */
    private $hebergementId;

    /**
     * @Assert\NotBlank(message="Champ description vide ! ")
     * @var string
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Veuillez saisir une chaine pas d'entiers"
     * )
     * Assert\Length(
     *      min = 5,
     *      max = 50,
     *   minMessage = "min error ",
     *   maxMessage = "max error "
     *   )
     *
     * @ORM\Column(name="Description", type="text", length=65535, nullable=false)
     * @Groups("post:read")
     */
    private $description;

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
     * @Groups("post:read")
     */
    private $type;

    /**
     * 
     * @var int
     * @Assert\NotBlank(message="Champ Disponibilite vide ! ")
     * @Assert\Expression(" this.getDisponibilite()==1 || this.getDisponibilite()==0  ",message="Dispo 0 ou 1 ")
     *
     * 
     * @ORM\Column(name="Disponibilité", type="integer", nullable=false)
     * @Groups("post:read")
     */
    private $Disponibilite;

    /**
     * @Assert\NotBlank(message="Champ adresse vide ! ")
     * @var string
     * 
     *
     * @ORM\Column(name="Adresse", type="string", length=255, nullable=false)
     * @Groups("post:read")
     */
    private $adresse;

    /**
     *
     * @var string
     * 
     * Assert\NotBlank(message="Champ image vide ! ")
     * @ORM\Column(name="Image", type="string", length=255, nullable=false)
     * @Groups("post:read")
     */
    private $image;

    /**
     * @Assert\NotBlank(message="Champ prix vide ! ")
     * @var int|null
     * @Assert\Positive(message="Le prix doit etre positif ! ")
     *
     * @ORM\Column(name="Prix", type="integer", nullable=true, options={"default"="NULL"})
     * @Groups("post:read")
     */
    private $prix = NULL;
// Kamel getter w setters

public function getHebergementId(): ?int
    {
        return $this->hebergementId;
    }

    public function setHebergementId(?int $hebergementId): self
    {
        $this->hebergementId = $hebergementId;

        return $this;
    }



public function __toString() {
    return $this->description;}

public function getType(): ?string
{
    return $this->type;
}

public function setType(string $type): self
{
    $this->type = $type;

    return $this;
}

//description
public function getDescription(): ?String
{
    return $this->description;
}

public function setDescription(String $description): self
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
    $this->Disponibilite = $Disponibilite;

    return $this;
}

public function getAdresse(): ?string
{
    return $this->adresse;
}

public function setAdresse(string $adresse): self
{
    $this->adresse = $adresse;

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

public function getPrix(): ?int
{
    return $this->prix;
}

public function setPrix(?int $prix): self
{
    $this->prix = $prix;

    return $this;
}

}
