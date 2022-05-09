<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Guide
 *
 * @ORM\Table(name="guide", indexes={@ORM\Index(name="id_vol", columns={"id_vol"})})
 * @ORM\Entity
 */
class Guide
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_g", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idG;

    /**
     * @var string
     *
     * @ORM\Column(name="Titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="Pays", type="string", length=250, nullable=false)
     */
    private $pays;

    /**
     * @var int
     *
     * @ORM\Column(name="Level", type="integer", nullable=false)
     */
    private $level;

    /**
     * @var \Vol
     *
     * @ORM\ManyToOne(targetEntity="Vol")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_vol", referencedColumnName="Vol_id")
     * })
     */
    private $idVol;


}
