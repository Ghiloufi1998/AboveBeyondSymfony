<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
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
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="date", nullable=true, options={"default"="NULL"})
     */
    private $date ;

    /**
     * @var string|null
     * @Assert\NotBlank
     *  @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="cannot contain a number"
     * )
     * @ORM\Column(name="Montant", type="text", length=65535, nullable=true, options={"default"="NULL"})
     */
    private $montant ;

    /**
     * @var string|null
     * @Assert\NotBlank
     * @ORM\Column(name="Mode_Pay", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $modePay ;

    public function getPaiId(): ?int
    {
        return $this->paiId;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(?string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getModePay(): ?string
    {
        return $this->modePay;
    }

    public function setModePay(?string $modePay): self
    {
        $this->modePay = $modePay;

        return $this;
    }


}
