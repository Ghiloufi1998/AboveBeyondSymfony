<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; 
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="PK_vol", columns={"vol_ID"}), @ORM\Index(name="PK_heb", columns={"Hebergement_id"}), @ORM\Index(name="Fk", columns={"ID_user"})})
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="rev_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")
     */
    private $revId;

    /**
     * @Assert\NotBlank(message="Vérifier la date! ")
     * @var \DateTime
     * @Assert\Expression("this.getDateDeb() < this.getDateFin()",message="Date début ne doit pas être dépassée la date fin")
     * @Assert\GreaterThan ("today",message="Vérifier la date!")
     *
     * @ORM\Column(name="Date_Deb", type="date", nullable=false)
     * @Groups("post:read")
     */
    private $dateDeb;

    /**
     * @Assert\NotBlank(message="Vérifier la date! ")
     * @var \DateTime
     * @Assert\Expression("this.getDateFin() > this.getDateDeb()",message="Date fin ne doit pas être antérieur à la date debut")
     * @Assert\GreaterThan ("today",message="Vérifier la date!")
     *
     * @ORM\Column(name="Date_Fin", type="date", nullable=false)
     * @Groups("post:read")
     */
    private $dateFin;

    /**
     * @Assert\NotBlank(message="Champ type vide ! ")

     * @var string
     * Assert\Length(
     *      min = 3,
     *      max = 12,
     *   minMessage = "min error ",
     *   maxMessage = "max error "
     *   )
     *
     *
     * @ORM\Column(name="Type", type="string", length=255, nullable=false)
     * @Groups("post:read")
     */
    private $type;

    /**
     * @var int
     * 
     * @Assert\NotBlank(message="Champ Nbr_adultes vide ! ")

     * @Assert\Positive(message="Le nombre d'adultes doit etre positif ! ")
     *
     * @ORM\Column(name="Nbr_adultes", type="integer", nullable=false)
     * @Groups("post:read")
     */
    private $nbrAdultes;

    /**
     * 
     * @var int
     * @Assert\NotBlank(message="Champ Nbr_enfants vide ! ")
     * @Assert\Positive(message="Le nombre d'enfants doit etre positif ! ")
     *
     * @ORM\Column(name="Nbr_enfants", type="integer", nullable=false)
     * @Groups("post:read")
     */
    private $nbrEnfants;

     /**
     * 
     * @var int
     *
     * @ORM\Column(name="ID_user", type="integer", nullable=true)
     * 
     */
    private $ID_user;

    /**
     * @var string
     *
     * 
     * @ORM\Column(name="Destination", type="string", length=255, nullable=false)
     * @Groups("post:read")
     */
    private $destination;

    /*Zeyd
    /**
     * @var int|null
     *
     * @ORM\Column(name="Hebergement_id", type="integer", nullable=true, options={"default"="NULL"})
     */
    //private $hebergementId = NULL;

    /* Zeyd 
    /**
     * @var int|null
     *
     * @ORM\Column(name="vol_ID", type="integer", nullable=true, options={"default"="NULL"})
     */
    //private $volId = NULL;


    //S7i7
    /**
     * @Assert\NotBlank(message="Veuillez Choisir Hebergement ! ")
     * @var \Hebergement
     *
     * @ORM\ManyToOne(targetEntity="Hebergement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Hebergement_id", referencedColumnName="Hebergement_id")
     * })
     * @Groups("post:read")
     */
    private $hebergement;


    /**
     * @Assert\NotBlank(message="Veuillez Choisir Destination ! ")
     * @var \Vol
     *
     * @ORM\ManyToOne(targetEntity="Vol")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Vol_id", referencedColumnName="Vol_id")
     * })
     * @Groups("post:read")
     */
    private $vol;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_user", referencedColumnName="id")
     * })
     * @Groups("post:read")
     */
    private $idUser;

    public function getRevId(): ?int
    {
        return $this->revId;
    }

    public function getDateDeb(): ?\DateTimeInterface
    {
        return $this->dateDeb;
    }

    public function setDateDeb(\DateTimeInterface $dateDeb): self
    {
        $this->dateDeb = $dateDeb;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNbrAdultes(): ?int
    {
        return $this->nbrAdultes;
    }

    public function setNbrAdultes(int $nbrAdultes): self
    {
        $this->nbrAdultes = $nbrAdultes;

        return $this;
    }
    public function setID_user(int $x): self
    {
        $this->ID_user = $x;

        return $this;
    }

    public function getNbrEnfants(): ?int
    {
        return $this->nbrEnfants;
    }

    public function setNbrEnfants(int $nbrEnfants): self
    {
        $this->nbrEnfants = $nbrEnfants;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    /*public function getHebergementId(): ?int
    {
        return $this->hebergementId;
    }

    public function setHebergementId(?int $hebergementId): self
    {
        $this->hebergementId = $hebergementId;

        return $this;
    }*/

   /* public function getVolId(): ?int
    {
        return $this->volId;
    }

    public function setVolId(?int $volId): self
    {
        $this->volId = $volId;

        return $this;
    }*/

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }
        // object join

        public function getHebergement(): ?Hebergement
        {
            return $this->hebergement;
        }

        public function setHebergement(?Hebergement $hebergement): self
        {
            $this->hebergement = $hebergement;

            return $this;
        }

        public function getVol(): ?Vol
        {
            return $this->vol;
        }

        public function setVol(?Vol $vol): self
        {
            $this->vol = $vol;

            return $this;
        }

        public function __toString() {
            return 'Type:   '.$this->type.'   Destination :  '.$this->destination.'  Adultes:  '.$this->nbrAdultes.'  Enfants : '.$this->nbrEnfants.'  Hebergement : '.$this->hebergement->getDescription()
            .' Date_Fin: '.$this->dateFin->format('Y-m-d H:i:s').' Date_Deb:  '.$this->dateDeb->format('Y-m-d H:i:s');}
       
}
