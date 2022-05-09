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
     * @ORM\Column(name="DisponibilitÃ©", type="integer", nullable=false)
     */
    private $disponibilitã©;

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
     * @ORM\Column(name="Prix", type="integer", nullable=true)
     */
    private $prix;


}
