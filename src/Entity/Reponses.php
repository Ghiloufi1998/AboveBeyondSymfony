<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\ReponsesRepository;

/**
 * Reponses
 *
 * @ORM\Table(name="réponses", indexes={@ORM\Index(name="Question_id", columns={"Question_id"})})
 * @ORM\Entity(repositoryClass=ReponsesRepository::class)
 */
class Reponses
{
    /**
     * @var int
     *
     * @ORM\Column(name="réponses_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")
     */
    private $reponsesId;

    /**
     * @var string
     *
     * @ORM\Column(name="réponse", type="string", length=50, nullable=false)
     *  @Assert\NotBlank(message="Veuillez Choisir une réponse ")
     * @Groups("post:read")
     */
    private $reponse;

    /**
     * @var \Questions
     *
     * @ORM\ManyToOne(targetEntity="Questions", inversedBy="Réponses")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Question_id", referencedColumnName="Question_id")
     * })
     * @Groups("post:read")
     */
    private $question;

   /*public function __construct(string $reponse, Questions $question)
    {
        $this->reponse = $reponse;
        $this->question = $question;

        
    }*/

    public function getReponsesId(): ?int
    {
        return $this->reponsesId;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getQuestion(): ?Questions
    {
        return $this->question;
    }

    public function setQuestion(?Questions $question): self
    {
        $this->question = $question;

        return $this;
    }

   
    public function __toString() {
        return $this->reponse;}



}
