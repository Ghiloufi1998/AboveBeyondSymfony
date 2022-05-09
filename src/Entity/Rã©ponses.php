<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * R�ponses
 *
 * @ORM\Table(name="réponses", indexes={@ORM\Index(name="Question_id", columns={"Question_id"})})
 * @ORM\Entity
 */
class R�ponses
{
    /**
     * @var int
     *
     * @ORM\Column(name="réponses_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $r�ponsesId;

    /**
     * @var string
     *
     * @ORM\Column(name="réponse", type="string", length=50, nullable=false)
     */
    private $r�ponse;

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
