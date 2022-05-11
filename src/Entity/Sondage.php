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
     * @ORM\Column(name="catégorie", type="string", length=20, nullable=false)
     */
    private $cat�gorie;

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

    public function getCat�gorie(): ?string
    {
        return $this->cat�gorie;
    }

    public function setCat�gorie(string $cat�gorie): self
    {
        $this->cat�gorie = $cat�gorie;

        return $this;
    }


}
