<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vol
 *
 * @ORM\Table(name="vol")
 * @ORM\Entity
 */
class Vol
{
    /**
     * @var int
     *
     * @ORM\Column(name="Vol_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $volId;

    /**
     * @var string
     *
     * @ORM\Column(name="Destination", type="string", length=255, nullable=false)
     */
    private $destination;

    /**
     * @var string
     *
     * @ORM\Column(name="DÃ©part", type="string", length=255, nullable=false)
     */
    private $dã©part;

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

    /**
     * @var float|null
     *
     * @ORM\Column(name="x", type="float", precision=10, scale=0, nullable=true)
     */
    private $x;

    /**
     * @var float|null
     *
     * @ORM\Column(name="y", type="float", precision=10, scale=0, nullable=true)
     */
    private $y;


}
