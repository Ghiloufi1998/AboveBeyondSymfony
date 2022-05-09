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
     * @ORM\Column(name="Date_ech", type="date", nullable=true)
     */
    private $dateEch;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Montant_ttc", type="integer", nullable=true)
     */
    private $montantTtc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Etat", type="string", length=255, nullable=true)
     */
    private $etat;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Pai_ID", type="integer", nullable=true)
     */
    private $paiId;

    /**
     * @var \Reservation
     *
     * @ORM\ManyToOne(targetEntity="Reservation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rev_ID", referencedColumnName="rev_ID")
     * })
     */
    private $rev;


}
