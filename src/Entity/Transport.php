<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="DisponibilitÃ©", type="integer", nullable=false)
     */
    private $disponibilitã©;

    /**
     * @var int
     *
     * @ORM\Column(name="Prix", type="integer", nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="Image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var \Hebergement
     *
     * @ORM\ManyToOne(targetEntity="Hebergement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Hebergement_id", referencedColumnName="Hebergement_id")
     * })
     */
    private $hebergement;


}
