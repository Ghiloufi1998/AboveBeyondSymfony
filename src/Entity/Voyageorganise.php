<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Voyageorganise
 *
 * @ORM\Table(name="voyageorganise", indexes={@ORM\Index(name="t_ck", columns={"Transport_id"}), @ORM\Index(name="vol_ck", columns={"Vol_id"})})
 * @ORM\Entity
 */
class Voyageorganise
{
    /**
     * @var int
     *
     * @ORM\Column(name="Voyage_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $voyageId;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="Image", type="string", length=100, nullable=false)
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="Prix", type="integer", nullable=false)
     */
    private $prix;

    /**
     * @var int
     *
     * @ORM\Column(name="Nbre_Places", type="integer", nullable=false)
     */
    private $nbrePlaces;

    /**
     * @var \Vol
     *
     * @ORM\ManyToOne(targetEntity="Vol")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Vol_id", referencedColumnName="Vol_id")
     * })
     */
    private $vol;

    /**
     * @var \Transport
     *
     * @ORM\ManyToOne(targetEntity="Transport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Transport_id", referencedColumnName="Transport_id")
     * })
     */
    private $transport;


}
