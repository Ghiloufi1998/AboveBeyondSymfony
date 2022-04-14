<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert; 
/**
 * @ORMEntity(repositoryClass="AppRepositoryMyClassRepository")
 */

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
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(name="sondage_id", type="integer", nullable=false)
     */
    private $sondageId;

    /**
     * @var string
     *
     * @ORM\Column(name="sujet", type="string", length=20, nullable=false)
     * @Assert\NotBlank(message="Veuillez Choisir un sujet")
     * * @Assert\Type(
     *     type="string",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "Le nom d'un article doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le nom d'un article doit comporter au plus {{ limit }} caractères"
     * )
     */
    private $sujet;

    /**
     * @var string
     *
     * @ORM\Column(name="catégorie", type="string", length=20, nullable=false)
     * @Assert\NotBlank(message="Veuillez Choisir une catégorie")
     * * @Assert\Type(
     *     type="string",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "Le nom d'un article doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le nom d'un article doit comporter au plus {{ limit }} caractères"
     * )
     */
    private $categorie;

     /**
      * @var \Doctrine\Common\Collections\ArrayCollection $question
     * @ORM\OneToMany(targetEntity="Questions", mappedBy="sondage", orphanRemoval=true)
     */
    private $question;

    public function __construct()
    {
        $this->question = new ArrayCollection();
    }

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

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
    public function __toString() {
        return $this->sujet;}


/**
 *  @return \Doctrine\Common\Collections\ArrayCollection
 */
    public function getQuestion(): Collection
    {
        return $this->question;
    }

    public function addQuestion(Questions $question): self
    {
        if (!$this->Questions->contains($question)) {
            $this->Questions[] = $question;
            $question->setSondage($this);
        }

        return $this;
    }

    public function removeQuestion(Questions $question): self
    {
        if ($this->Questions->contains($question)) {
            $this->Questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getSondage() === $this) {
                $question->setSondage(null);
            }
        }

        return $this;
    }
    
    }

    


