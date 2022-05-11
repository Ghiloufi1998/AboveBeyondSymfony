<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; 

/**
 * Vol
 *
 * @ORM\Table(name="vol")
 * @ORM\Entity
 */
class Vol
{
    /**
     * 
     * 
     * 
     * 
     * @var int
     *
     * @ORM\Column(name="Vol_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $volId;

    /**
     * @Assert\NotBlank
     * 
     * @var string
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *   minMessage = "min error ",
     *   maxMessage = "max error "
     *   )
     *
     * @ORM\Column(name="Destination", type="string", length=255, nullable=false)
     */

     
    
    private $destination;

       

    /**
     * @var string
     *@Assert\Length(
     *      min = 3,
     *      max = 50,
     *   minMessage = "min error ",
     *   maxMessage = "max error "
     *   )
     * @ORM\Column(name="Depart", type="string", length=255, nullable=false)
     */
    private $depart;

    /**
     * @var string
     *
     * @ORM\Column(name="Image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Prix", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $prix = NULL;

    /**
     * @var float|null
     *
     * @ORM\Column(name="x", type="float", precision=10, scale=0, nullable=true, options={"default"="NULL"})
     */
    private $x = NULL;

    /**
     * @var float|null
     *
     * @ORM\Column(name="y", type="float", precision=10, scale=0, nullable=true, options={"default"="NULL"})
     */
    private $y = NULL;

    public function getVolId(): ?int
    {
        return $this->volId;
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

    public function getdepart(): ?string
    {
        return $this->depart;
    }

    public function setdepart(string $depart): self
    {
        $this->depart = $depart;

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

    public function setPrix(?int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getX(): ?float
    {
        return $this->x;
    }

    public function setX(?float $x): self
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): ?float
    {
        return $this->y;
    }

    public function setY(?float $y): self
    {
        $this->y = $y;

        return $this;
    }

    public function __toString() {
        return $this->destination;}
    


}
