<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use App\Repository\ParcourRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"Parcour:read"}},
 *     denormalizationContext={"groups"={"Parcour:write"}},
 *     itemOperations={"get","patch"}
 * )
 * @ApiFilter(OrderFilter::class, properties={"id": "DESC"})
 * @ORM\Entity(repositoryClass=ParcourRepository::class)
 */
class Parcour
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ("Parcour:read")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"Parcour:read", "Parcour:write"})
     */
    private $debut;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"Parcour:read", "Parcour:write"})
     */
    private $fin;

    /**
     * @ORM\OneToMany(targetEntity=Position::class, mappedBy="parcourt", orphanRemoval=true)
     * @Groups ("Parcour:read")
     * @ApiSubresource
     */
    private $positions;

    public function __construct()
    {
        $this->positions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(\DateTimeInterface $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(?\DateTimeInterface $fin): self
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * @return Collection|Position[]
     */
    public function getPositions(): Collection
    {
        return $this->positions;
    }

    public function addPosition(Position $position): self
    {
        if (!$this->positions->contains($position)) {
            $this->positions[] = $position;
            $position->setParcourt($this);
        }

        return $this;
    }

    public function removePosition(Position $position): self
    {
        if ($this->positions->removeElement($position)) {
            // set the owning side to null (unless already changed)
            if ($position->getParcourt() === $this) {
                $position->setParcourt(null);
            }
        }

        return $this;
    }
}
