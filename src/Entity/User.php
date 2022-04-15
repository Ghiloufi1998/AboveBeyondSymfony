<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(
 * fields = {"email"},
 * message ="Email déja utilisé !"
 * )
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Name is required")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Last nname is required")
     */
    private $fname;

    

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Gender is required")
     */
    private $gender;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Num is required")
     * @Assert\Length(min="8",minMessage="Votre num de télèphone doit contenir 8 entiers")
     * @Assert\Length(max="8",maxMessage="Votre num de télèphone doit contenir 8 entiers")
     */
    private $num;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Email is required")
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Password is required")
     * @Assert\Length(min="6",minMessage="Votre mot de passe doit contenir au min 6 caractères")
     */
    private $password;

    /**
     *@Assert\NotBlank(message="Confirmpassword is required")
     *@Assert\EqualTo(propertyPath="password",message="Vérifier votre password")
     */

    private $confirmpassword;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="Birthday is required")
     * @Assert\LessThan("today")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     * @Assert\NotBlank(message="Il faut insérer une image")
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=Reclamation::class, mappedBy="user", orphanRemoval=true)
     */
    private $reclamations;

    public function __construct()
    {
        $this->reclamations = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFname(): ?string
    {
        return $this->fname;
    }

    public function setFname(string $fname): self
    {
        $this->fname = $fname;

        return $this;
    }

    

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(int $num): self
    {
        $this->num = $num;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function getconfirmpassword(): ?string
    {
        return $this->confirmpassword;
    }

    public function setconfirmpassword(string $confirmpassword): self
    {
        $this->confirmpassword = $confirmpassword;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|Reclamation[]
     */
    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): self
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations[] = $reclamation;
            $reclamation->setUser($this);
        }

        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): self
    {
        if ($this->reclamations->removeElement($reclamation)) {
            // set the owning side to null (unless already changed)
            if ($reclamation->getUser() === $this) {
                $reclamation->setUser(null);
            }
        }

        return $this;
    }
}
