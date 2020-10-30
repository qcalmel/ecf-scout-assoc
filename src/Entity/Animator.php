<?php

namespace App\Entity;

use App\Repository\AnimatorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnimatorRepository::class)
 */
class Animator
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $firstName;

    /**
     * @ORM\ManyToMany(targetEntity=Camp::class, mappedBy="animators")
     */
    private $camps;

    public function __construct()
    {
        $this->camps = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

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
            $camp->addAnimator($this);
        }

        return $this;
    }

    public function removeCamp(Camp $camp): self
    {
        if ($this->camps->removeElement($camp)) {
            $camp->removeAnimator($this);
        }

        return $this;
    }
    public function getFullName(): ?string
    {
        $fullName = $this->firstName ? $this->firstName." ": "";
        $fullName .= strtoupper($this->lastName);
        return $fullName;
    }
}
