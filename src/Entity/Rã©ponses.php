<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rã©ponses
 *
 * @ORM\Table(name="rÃ©ponses", indexes={@ORM\Index(name="Question_id", columns={"Question_id"})})
 * @ORM\Entity
 */
class Rã©ponses
{
    /**
     * @var int
     *
     * @ORM\Column(name="rÃ©ponses_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $rã©ponsesId;

    /**
     * @var string
     *
     * @ORM\Column(name="rÃ©ponse", type="string", length=50, nullable=false)
     */
    private $rã©ponse;

    /**
     * @var \Questions
     *
     * @ORM\ManyToOne(targetEntity="Questions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Question_id", referencedColumnName="Question_id")
     * })
     */
    private $question;


}
