<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $hebergementId;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="Disponibilité", type="integer", nullable=false)
     */
    private $Disponibilite;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse", type="string", length=255, nullable=false)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="Image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Prix", type="integer", nullable=true, options={"default"="NULL"})
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
