<?php

namespace App\Entity;

use App\Repository\AgeRangeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgeRangeRepository::class)
 */
class AgeRange
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $singularName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $pluralName;

    /**
     * @ORM\Column(type="integer")
     */
    private $minAge;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxAge;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbChildrenByAnimator;

    /**
     * @ORM\OneToMany(targetEntity=Child::class, mappedBy="ageRange")
     */
    private $children;

    /**
     * @ORM\OneToMany(targetEntity=Camp::class, mappedBy="ageRange")
     */
    private $camps;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->camps = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSingularName(): ?string
    {
        return $this->singularName;
    }

    public function setSingularName(string $singularName): self
    {
        $this->singularName = $singularName;

        return $this;
    }

    public function getPluralName(): ?string
    {
        return $this->pluralName;
    }

    public function setPluralName(string $pluralName): self
    {
        $this->pluralName = $pluralName;

        return $this;
    }

    public function getMinAge(): ?int
    {
        return $this->minAge;
    }

    public function setMinAge(int $minAge): self
    {
        $this->minAge = $minAge;

        return $this;
    }

    public function getMaxAge(): ?int
    {
        return $this->maxAge;
    }

    public function setMaxAge(int $maxAge): self
    {
        $this->maxAge = $maxAge;

        return $this;
    }

    public function getNbChildrenByAnimator(): ?int
    {
        return $this->nbChildrenByAnimator;
    }

    public function setNbChildrenByAnimator(int $nbChildrenByAnimator): self
    {
        $this->nbChildrenByAnimator = $nbChildrenByAnimator;

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
            $child->setAgeRange($this);
        }

        return $this;
    }

    public function removeChild(Child $child): self
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getAgeRange() === $this) {
                $child->setAgeRange(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Camp[]
     */
    public function getCamps(): Collection
    {
        return $this->camps;
    }

    public function addCamp(Camp $camp): self
    {
        if (!$this->camps->contains($camp)) {
            $this->camps[] = $camp;
            $camp->setAgeRange($this);
        }

        return $this;
    }

    public function removeCamp(Camp $camp): self
    {
        if ($this->camps->removeElement($camp)) {
            // set the owning side to null (unless already changed)
            if ($camp->getAgeRange() === $this) {
                $camp->setAgeRange(null);
            }
        }

        return $this;
    }

    public function getdetailedName() {
        $detailedName = $this->singularName." ( ".$this->minAge." à ".$this->maxAge." ans)";
        return $detailedName;
    }
}
