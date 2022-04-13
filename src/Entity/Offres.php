<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     *
     * @ORM\Column(name="Description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="Nb_point_req", type="integer", nullable=false)
     */
    private $nbPointReq;

    /**
     * @var string
     *
     * @ORM\Column(name="Destination", type="string", length=250, nullable=false)
     */
    private $destination;

    /**
     * @var int
     *
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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNbPointReq(): ?int
    {
        return $this->nbPointReq;
    }

    public function setNbPointReq(int $nbPointReq): self
    {
        $this->nbPointReq = $nbPointReq;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getPourcentageRed(): ?int
    {
        return $this->pourcentageRed;
    }

    public function setPourcentageRed(int $pourcentageRed): self
    {
        $this->pourcentageRed = $pourcentageRed;

        return $this;
    }


}
