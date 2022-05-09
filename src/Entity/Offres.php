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


}
