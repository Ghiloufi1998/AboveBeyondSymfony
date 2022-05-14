<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="Fk", columns={"ID_user"}), @ORM\Index(name="PK_vol", columns={"vol_ID"}), @ORM\Index(name="PK_heb", columns={"Hebergement_id"})})
 * @ORM\Entity
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
     * @ORM\Column(name="Hebergement_id", type="integer", nullable=true)
     */
    private $hebergementId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="vol_ID", type="integer", nullable=true)
     */
    private $volId;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_user", referencedColumnName="id")
     * })
     */
    private $idUser;


}
