<?php

namespace App\Entity;

use App\Repository\FeedbackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="feedback")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass=FeedbackRepository::class)
 */
class Feedback
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $commentaire;

    /**
     * @ORM\Column(name="created_at", type="date", nullable=false)
     */
    private $created_AT;

    /**
     * @ORM\Column(name="nbrLikes", type="integer", nullable=true)
     */
    private $nbrLikes;


    /**
     * @ORM\OneToMany(targetEntity=CommentLikes::class, mappedBy="Feedback")
     */
    private $likes;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }


    public function getNbrLikes(): ?int
    {
        return $this->nbrLikes;
    }

    public function setNbrLikes(int $nbrLikes): self
    {
        $this->nbrLikes = $nbrLikes;

        return $this;
    }

    public function getCreatedAT(): ?\DateTimeInterface
    {
        return $this->created_AT;
    }

    public function setCreatedAT(\DateTimeInterface $created_AT): self
    {
        $this->created_AT = $created_AT;

        return $this;
    }

    /**
     * @return Collection<int, CommentLikes>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(CommentLikes $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setFeedback($this);
        }

        return $this;
    }

    public function removeLike(CommentLikes $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getFeedback() === $this) {
                $like->setFeedback(null);
            }
        }

        return $this;
    }
}
