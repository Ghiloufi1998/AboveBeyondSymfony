<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sondage
 *
 * @ORM\Table(name="sondage")
 * @ORM\Entity
 */
class Sondage
{
    /**
     * @var int
     *
     * @ORM\Column(name="sondage_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $sondageId;

    /**
     * @var string
     *
     * @ORM\Column(name="sujet", type="string", length=20, nullable=false)
     */
    private $sujet;

    /**
     * @var string
     *
     * @ORM\Column(name="catÃ©gorie", type="string", length=20, nullable=false)
     */
    private $catã©gorie;

    public function getSondageId(): ?int
    {
        return $this->sondageId;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getCatã©gorie(): ?string
    {
        return $this->catã©gorie;
    }

    public function setCatã©gorie(string $catã©gorie): self
    {
        $this->catã©gorie = $catã©gorie;

        return $this;
    }


}
