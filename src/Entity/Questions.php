<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORMEntity(repositoryClass="AppRepositoryMyClassRepository")
 */


/**
 * Questions
 *
 * @ORM\Table(name="questions", indexes={@ORM\Index(name="questions_ibfk_1", columns={"sondage_id"})})
 * @ORM\Entity
 */
class Questions
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="Question_id", type="integer", nullable=false)
     */
    private $questionId;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="Veuillez entrer un question")
     * @Assert\Type(
     *     type="string",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * 
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=20, nullable=false)
     * @Assert\NotBlank(message="Veuillez Choisir un type")
     * @Assert\Type(
     *     type="string",
     *     message="The value {{ value }} is not a valid {{ type }}."
     *    )
     */
    private $type;

    /**
     * @var \Sondage
     *
     * @ORM\ManyToOne(targetEntity="Sondage",inversedBy="Questions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sondage_id", referencedColumnName="sondage_id")
     *
     * })
     *  @Assert\NotBlank(message="Veuillez Choisir un sondage")
     */
    private $sondage;

    public function getQuestionId(): ?int
    {
        return $this->questionId;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

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

    public function getSondage(): ?Sondage
    {
        return $this->sondage;
    }

    public function setSondage(?Sondage $sondage): self
    {
        $this->sondage = $sondage;

        return $this;
    }
    public function __toString() {
        return $this->question;}



   
 
}


