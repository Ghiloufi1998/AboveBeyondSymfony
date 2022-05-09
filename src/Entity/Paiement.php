<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paiement
 *
 * @ORM\Table(name="paiement")
 * @ORM\Entity
 */
class Paiement
{
    /**
     * @var int
     *
     * @ORM\Column(name="Pai_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $paiId;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Date", type="date", nullable=true)
     */
    private $date;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Montant", type="text", length=65535, nullable=true)
     */
    private $montant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Mode_Pay", type="string", length=255, nullable=true)
     */
    private $modePay;


}
