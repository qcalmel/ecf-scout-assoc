<?php

namespace App\Entity;

use App\Repository\AgeRangeRepository;
use App\Repository\ChildRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ChildRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Child
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
     * @ORM\Column(type="date")
     */
    private $birthDate;

    /**
     * @ORM\ManyToMany(targetEntity=Camp::class, mappedBy="children")
     */
    private $camps;

    /**
     * @ORM\ManyToOne(targetEntity=AgeRange::class, inversedBy="children")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ageRange;

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
     * @return \DateTimeInterface|null
     * @Assert\GreaterThanOrEqual(
     *     value="-17 years",
     *     message="L'enfant est trop vieux"
     * )
     * @Assert\LessThanOrEqual(
     *     value="-6 years",
     *     message="L'enfant est trop jeune"
     * )
     */
    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

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
            $camp->addChild($this);
        }

        return $this;
    }

    public function removeCamp(Camp $camp): self
    {
        if ($this->camps->removeElement($camp)) {
            $camp->removeChild($this);
        }

        return $this;
    }

    public function getAgeRange(): ?AgeRange
    {
        return $this->ageRange;
    }

    public function setAgeRange(AgeRangeRepository $repository)
    {
        $age = (new \DateTime())->diff($this->birthDate)->format('%y');
        $ageRange = $repository->getAgeRange($age);
        $this->ageRange = $ageRange;
    }

    /**
     * @ORM\PrePersist()
     * @param LifecycleEventArgs $args
     * @return void
     */
    public function prePersistEvents(LifecycleEventArgs $args)
    {
        $age = (new \DateTime())->diff($this->birthDate)->format('%y');
//        $ageRange = $args->getEntityManager()->getRepository(AgeRange::class)->findAgeRange($age);
        $this->firstName = $age;
    }
}
