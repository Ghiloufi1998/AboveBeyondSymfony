<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; 

/**
 * Voyageorganise
 *
 * @ORM\Table(name="voyageorganise", indexes={@ORM\Index(name="t_ck", columns={"Transport_id"}), @ORM\Index(name="vol_ck", columns={"Vol_id"})})
 * @ORM\Entity
 */
class Voyageorganise
{
    /**
     * @var int
     *
     * @ORM\Column(name="Voyage_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $voyageId;

    /**
     * @Assert\NotBlank(message="Veuillez remplir  ce champ! ")
     * @var string
     * Assert\Length(
     *      min = 3,
     *      max = 12,
     *   minMessage = "min error ",
     *   maxMessage = "max error "
     *   )
     *
     * @ORM\Column(name="Description", type="text", length=65535, nullable=false)
     */
    private $description;

     /**
     * Assert\NotBlank(message="Champ image vide ! ")
     * @var string
     * Assert\Length(
     *      min = 5,
     *      max = 50,
     *   minMessage = "min error ",
     *   maxMessage = "max error "
     *   )
     *
     * @ORM\Column(name="Image", type="string", length=100, nullable=false)
     */
    private $image;

    /**
     * @Assert\NotBlank(message="Veuillez indiquer le  prix ! ")
     * @var int|null
     * @Assert\Positive(message="Le prix doit etre positif ! ")
     *
     * @ORM\Column(name="Prix", type="integer", nullable=false)
     */
    private $prix;

    /**
     * @Assert\NotBlank(message="Veuillez indiquer le  nombre de places ! ")
     * @var int|null
     * @Assert\Positive(message="Le nombre doit etre positif ! ")
     *
     * @ORM\Column(name="Nbre_Places", type="integer", nullable=false)
     */
    private $nbrePlaces;

    /**
     * @var \Vol
     *
     * @ORM\ManyToOne(targetEntity="Vol")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Vol_id", referencedColumnName="Vol_id")
     * })
     */
    private $vol;
   
    /**
     * @var \Transport
     *
     * @ORM\ManyToOne(targetEntity="Transport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Transport_id", referencedColumnName="Transport_id")
     * })
     */
    private $transport;
   

    public function getVoyageId(): ?int
    {
        return $this->voyageId;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getNbrePlaces(): ?int
    {
        return $this->nbrePlaces;
    }

    public function setNbrePlaces(int $nbrePlaces): self
    {
        $this->nbrePlaces = $nbrePlaces;

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

    public function getTransport(): ?Transport
    {
        return $this->transport;
    }

    public function setTransport(?Transport $transport): self
    {
        $this->transport = $transport;

        return $this;
    }


}
