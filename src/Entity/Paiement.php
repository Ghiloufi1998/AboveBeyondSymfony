<?php

namespace App\Entity;
use Symfony\Component\Serializer\Annotation\Groups;
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
     *@Groups("post:read")
     * @ORM\Column(name="Pai_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $paiId;

    /**
     * @var \DateTime
     * @Groups("post:read")
     *@Assert\GreaterThanOrEqual("today")
     * @ORM\Column(name="Date", type="date", nullable=true, options={"default": "CURRENT_TIMESTAMP"})
     */
    private $date ;
   
    /**
     * @var int
     * @Groups("post:read")
     * @Assert\Positive
     * @ORM\Column(name="Montant", type="integer", length=65535, nullable=true, options={"default"="0"})
     */
    private $montant ;

    /**
     * @var string|null
     * @Groups("post:read")
     * @Assert\NotBlank
     * @ORM\Column(name="Mode_Pay", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $modePay ;
    public function __construct(){
        $this->setdate(new \DateTime());
    }

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
