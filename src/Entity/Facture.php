<?php

namespace App\Entity;
use Symfony\Component\Serializer\Annotation\Groups; 
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Facture
 *
 * @ORM\Table(name="facture", indexes={@ORM\Index(name="PK_rev", columns={"rev_ID"}), @ORM\Index(name="Pk_paiment", columns={"Pai_ID"})})
 * @ORM\Entity
 */
class Facture
{
    /**
     * @var int
     * @ORM\Column(name="ID_fac", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")
     */
    private $idFac;

    /**
     * @var \DateTime|null
     * @Assert\NotBlank
     *   @Groups("post:read")
     * @Assert\GreaterThanOrEqual("today")
     * 
     * @ORM\Column(name="Date_ech", type="date", nullable=true, options={"default": "CURRENT_TIMESTAMP"})
     * 
     */
    private $dateEch ;
   

    /**
     * @var int|null
     * @Groups("post:read")
     * @Assert\NotBlank
     * @Assert\Positive
     * @Assert\GreaterThan(0)
     * @ORM\Column(name="Montant_ttc", type="integer", nullable=true, options={"default"="NULL"})
     * 
     */
    private $montantTtc = NULL;

    /**
     *  
     * @var string|null
     * 
     * @Assert\NotBlank
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="cannot contain a number"
     * )
     * @Groups("post:read")
     * @ORM\Column(name="Etat", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $etat ;

    /**
     * @var \Reservation
     *
     * @ORM\ManyToOne(targetEntity="Reservation")
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="rev_ID", referencedColumnName="rev_ID",onDelete="CASCADE")
     * })
     */
    private $rev;

    /**
     * @var \Paiement
     * 
     * @ORM\ManyToOne(targetEntity="Paiement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Pai_ID", referencedColumnName="Pai_ID")
     * })
     */
    private $pai;

    public function getIdFac(): ?int
    {
        return $this->idFac;
    }

    public function  getDateEch(): ?\DateTimeInterface
    {
        return $this->dateEch;
    }

    public function setDateEch(?\DateTimeInterface $dateEch): self
    {
        $this->dateEch = $dateEch;  

        return $this;
    }

    public function getMontantTtc(): ?int
    {
        return $this->montantTtc;
    }

    public function setMontantTtc(?int $montantTtc): self
    {
        $this->montantTtc = $montantTtc;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getRev(): ?Reservation
    {
        return $this->rev;
    }

    public function setRev(?Reservation $rev): self
    {
        $this->rev = $rev;

        return $this;
    }

    public function getPai(): ?Paiement
    {
        return $this->pai;
    }

    public function setPai(?Paiement $pai): self
    {
        $this->pai = $pai;

        return $this;
    }
    public function __toString(): string
    {
         
         return 'Facture Id:   '.$this->idFac.'   date écheance :  '.$this->dateEch.'  Montant:  '.$this->montantTtc.'  etat : '.$this->etat
        
         ;
        
        }
    
    }


