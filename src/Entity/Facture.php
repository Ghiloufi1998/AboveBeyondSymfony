<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table(name="facture", indexes={@ORM\Index(name="Pk_paiment", columns={"Pai_ID"}), @ORM\Index(name="PK_rev", columns={"rev_ID"})})
 * @ORM\Entity
 */
class Facture
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_fac", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFac;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Date_ech", type="date", nullable=true, options={"default"="NULL"})
     */
    private $dateEch = 'NULL';

    /**
     * @var int|null
     *
     * @ORM\Column(name="Montant_ttc", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $montantTtc = NULL;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Etat", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $etat = 'NULL';

    /**
     * @var \Paiement
     *
     * @ORM\ManyToOne(targetEntity="Paiement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Pai_ID", referencedColumnName="Pai_ID")
     * })
     */
    private $pai;

    /**
     * @var \Reservation
     *
     * @ORM\ManyToOne(targetEntity="Reservation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rev_ID", referencedColumnName="rev_ID")
     * })
     */
    private $rev;

    public function getIdFac(): ?int
    {
        return $this->idFac;
    }

    public function getDateEch(): ?\DateTimeInterface
    {
        return $this->dateEch;
    }

    public function setDateEch(?\DateTimeInterface $dateEch): self
    {
        $this->dateEch = $dateEch;

        return $this;
    }

    public function getMontantTtc(): ?int
    {
        return $this->montantTtc;
    }

    public function setMontantTtc(?int $montantTtc): self
    {
        $this->montantTtc = $montantTtc;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getPai(): ?Paiement
    {
        return $this->pai;
    }

    public function setPai(?Paiement $pai): self
    {
        $this->pai = $pai;

        return $this;
    }

    public function getRev(): ?Reservation
    {
        return $this->rev;
    }

    public function setRev(?Reservation $rev): self
    {
        $this->rev = $rev;

        return $this;
    }


}
