<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Offres
 *
 * @ORM\Table(name="offres")
 * @ORM\Entity
 */
class Offres
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_off", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idOff;

    /**
     * @var string|null
     * @Assert\NotBlank
     * @ORM\Column(name="Description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var int|null
     * @Assert\NotBlank
     * @ORM\Column(name="Nb_point_req", type="integer", nullable=false)
     */
    private $nbPointReq;

    /**
     * @var string|null
     * @Assert\NotBlank
     * @ORM\Column(name="Destination", type="string", length=250, nullable=false)
     */
    private $destination;

    /**
     * @var int|null
     * @Assert\NotBlank
     * @ORM\Column(name="Pourcentage_red", type="integer", nullable=false)
     */
    private $pourcentageRed;

    public function getIdOff(): ?int
    {
        return $this->idOff;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = (string)$description;

        return $this;
    }

    public function getNbPointReq(): ?int
    {
        return $this->nbPointReq;
    }

    public function setNbPointReq(?int  $nbPointReq): self
    {
        $this->nbPointReq = (int) $nbPointReq;

        return $this;
    }
    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(?string $destination): self
    {
        $this->destination = (string)$destination;

        return $this;
    }

    public function getPourcentageRed(): ?int
    {
        return $this->pourcentageRed;
    }

    public function setPourcentageRed(?int $pourcentageRed): self
    {
        $this->pourcentageRed =(int) $pourcentageRed;

        return $this;
    }


}
