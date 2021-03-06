<?php

namespace App\Entity;

use App\Repository\CommentLikesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 
 * @ORM\Table(name="commentlikes", indexes={@ORM\Index(name="id", columns={"ids"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass=CommentLikesRepository::class)
 */
class CommentLikes
{
    /**
     * @ORM\Id
     
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * 
     * 
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Feedback::class, inversedBy="likes")
     */
    private $Feedback;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFeedback(): ?Feedback
    {
        return $this->Feedback;
    }

    public function setFeedback(?Feedback $Feedback): self
    {
        $this->Feedback = $Feedback;

        return $this;
    }
}
