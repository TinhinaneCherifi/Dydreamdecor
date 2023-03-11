<?php

namespace App\Entity;

use App\Repository\InspirationCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InspirationCategoryRepository::class)]
class InspirationCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Inspiration::class)]
    private $inspirations;

    public function __construct()
    {
        $this->inspirations = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
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

    /**
     * @return Collection<int, Inspiration>
     */
    public function getInspirations(): Collection
    {
        return $this->inspirations;
    }

    public function addInspiration(Inspiration $inspiration): self
    {
        if (!$this->inspirations->contains($inspiration)) {
            $this->inspirations[] = $inspiration;
            $inspiration->setCategory($this);
        }

        return $this;
    }

    public function removeInspiration(Inspiration $inspiration): self
    {
        if ($this->inspirations->removeElement($inspiration)) {
            // set the owning side to null (unless already changed)
            if ($inspiration->getCategory() === $this) {
                $inspiration->setCategory(null);
            }
        }

        return $this;
    }
}
