<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 * @ORM\Table(name="`admin`")
 * @UniqueEntity(
 * fields = {"email"},
 * message ="Email déja utilisé !"
 * )
 */
class Admin
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Name is required")
     */
    private $adminname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Last nname is required")
     */
    private $lastname;

 
    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="Gender is required")
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Num is required")
     * @Assert\Length(min="8",minMessage="Votre num de télèphone doit contenir 8 entiers")
     * @Assert\Length(max="8",maxMessage="Votre num de télèphone doit contenir 8 entiers")
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Email is required")
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Password is required")
     * @Assert\Length(min="6",minMessage="Votre mot de passe doit contenir au min 6 caractères")
     */
    private $password;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="Birthday is required")
     * @Assert\LessThan("today")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Assert\NotBlank(message="Il faut insérer une image")
     */
    private $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdminname(): ?string
    {
        return $this->adminname;
    }

    public function setAdminname(string $adminname): self
    {
        $this->adminname = $adminname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface 
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface  $birthday): self
    {
        $this->birthday = $birthday;

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

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

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

    public function getImage()
    {
        return $this->image;
    }

    public function setImage( $image)
    {
        $this->image = $image;

        return $this;
    }
}
