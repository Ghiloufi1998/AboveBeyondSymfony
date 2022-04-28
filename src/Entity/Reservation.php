<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="PK_vol", columns={"vol_ID"}), @ORM\Index(name="PK_heb", columns={"Hebergement_id"}), @ORM\Index(name="Fk", columns={"ID_user"})})
 * 
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="rev_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $revId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Deb", type="date", nullable=false)
     */
    private $dateDeb;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Fin", type="date", nullable=false)
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="Nbr_adultes", type="integer", nullable=false)
     */
    private $nbrAdultes;

    /**
     * @var int
     *
     * @ORM\Column(name="Nbr_enfants", type="integer", nullable=false)
     */
    private $nbrEnfants;

    /**
     * @var string
     *
     * @ORM\Column(name="Destination", type="string", length=255, nullable=false)
     */
    private $destination;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Hebergement_id", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $hebergementId = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="vol_ID", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $volId = NULL;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_user", referencedColumnName="id")
     * })
     */
    private $idUser;

    public function getRevId(): ?int
    {
        return $this->revId;
    }

    public function getDateDeb(): ?\DateTimeInterface
    {
        return $this->dateDeb;
    }

    public function setDateDeb(\DateTimeInterface $dateDeb): self
    {
        $this->dateDeb = $dateDeb;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
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

    public function getNbrAdultes(): ?int
    {
        return $this->nbrAdultes;
    }

    public function setNbrAdultes(int $nbrAdultes): self
    {
        $this->nbrAdultes = $nbrAdultes;

        return $this;
    }

    public function getNbrEnfants(): ?int
    {
        return $this->nbrEnfants;
    }

    public function setNbrEnfants(int $nbrEnfants): self
    {
        $this->nbrEnfants = $nbrEnfants;

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

    public function getHebergementId(): ?int
    {
        return $this->hebergementId;
    }

    public function setHebergementId(?int $hebergementId): self
    {
        $this->hebergementId = $hebergementId;

        return $this;
    }

    public function getVolId(): ?int
    {
        return $this->volId;
    }

    public function setVolId(?int $volId): self
    {
        $this->volId = $volId;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }


}
