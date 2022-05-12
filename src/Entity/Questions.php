<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @ORM\Column(name="Question_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")
     */
    private $questionId;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=50, nullable=false)
     * @Groups("post:read")
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=20, nullable=false)
     * @Groups("post:read")
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
     * @Groups("post:read")
     */
    private $sondage;



    public function __construct()
    {
        $this->reponse = new ArrayCollection();
    }

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


     /*   
/**
 *  @return \Doctrine\Common\Collections\ArrayCollection
 */

   /* public function addReponse(Reponses $reponse): self
    {
        if (!$this->Reponses->contains($reponse)) {
            $this->Reponses[] = $reponse;
            $reponse->setQuestion($this);
        }

        return $this;
    }*/



}
