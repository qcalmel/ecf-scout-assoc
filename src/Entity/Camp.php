<?php

namespace App\Entity;

use App\Repository\CampRepository;
use App\Validator\EnoughAnimators;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CampRepository::class)
 */
class Camp
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
    private $name;

    /**
     * @ORM\Column(type="date")
     */
    private $startDate;

    /**
     * @ORM\Column(type="date")
     */
    private $endDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacity;

    /**
     * @ORM\ManyToMany(targetEntity=Animator::class, inversedBy="camps")
     * @EnoughAnimators()
     */
    private $animators;

    /**
     * @ORM\ManyToMany(targetEntity=Child::class, inversedBy="camps")
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity=AgeRange::class, inversedBy="camps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ageRange;

    public function __construct()
    {
        $this->animators = new ArrayCollection();
        $this->children = new ArrayCollection();
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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * @return Collection|Animator[]
     */
    public function getAnimators(): Collection
    {
        return $this->animators;
    }

    public function addAnimator(Animator $animator): self
    {
        if (!$this->animators->contains($animator)) {
            $this->animators[] = $animator;
        }

        return $this;
    }

    public function removeAnimator(Animator $animator): self
    {
        $this->animators->removeElement($animator);

        return $this;
    }

    /**
     * @return Collection|Child[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Child $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
        }

        return $this;
    }

    public function removeChild(Child $child): self
    {
        $this->children->removeElement($child);

        return $this;
    }

    public function getAgeRange(): ?AgeRange
    {
        return $this->ageRange;
    }

    public function setAgeRange(?AgeRange $ageRange): self
    {
        $this->ageRange = $ageRange;

        return $this;
    }

    public function isEnoughAnimators(){
        return ceil($this->capacity/$this->getAgeRange()->getNbChildrenByAnimator()) ;
    }
}
