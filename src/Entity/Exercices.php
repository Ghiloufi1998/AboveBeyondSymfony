<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exercices
 *
 * @ORM\Table(name="exercices", indexes={@ORM\Index(name="ID_crs", columns={"ID_crs"})})
 * @ORM\Entity
 */
class Exercices
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_ex", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEx;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=250, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="Question", type="string", length=250, nullable=false)
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(name="Reponse", type="string", length=250, nullable=false)
     */
    private $reponse;

    /**
     * @var string
     *
     * @ORM\Column(name="Hint", type="string", length=255, nullable=false)
     */
    private $hint;

    /**
     * @var \Cours
     *
     * @ORM\ManyToOne(targetEntity="Cours")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_crs", referencedColumnName="ID_crs")
     * })
     */
    private $idCrs;


}
