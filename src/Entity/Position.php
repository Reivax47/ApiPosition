<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use App\Repository\PositionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"Position:read"}},
 *     denormalizationContext={"groups"={"Position:write"}},
 *     itemOperations={"get"},
 *
 *     )
 * @ApiFilter(OrderFilter::class, properties={"datePosition": "DESC"})
 * @ORM\Entity(repositoryClass=PositionRepository::class)
 */
class Position
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ("Position:read")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups({"Position:read", "Position:write","Parcour:read"})
     */
    private $latitude;

    /**
     * @ORM\Column(type="float")
     * @Groups({"Position:read", "Position:write", "Parcour:read"})
     */
    private $longitude;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"Position:read", "Position:write", "Parcour:read"})
     */
    private $datePosition;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"Position:read", "Position:write", "Parcour:read"})
     */
    private $dateInsertion;

    /**
     * @ORM\ManyToOne(targetEntity=Parcour::class, inversedBy="positions")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"Position:read", "Position:write"})
     */
    private $parcourt;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"Position:read", "Position:write", "Parcour:read"})
     */
    private $accuracy;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"Position:read", "Position:write", "Parcour:read"})
     */
    private $fromfield;

    public function __construct()
    {

        $this->dateInsertion = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getDatePosition(): ?\DateTimeInterface
    {
        return $this->datePosition;
    }

    public function setDatePosition(\DateTimeInterface $datePosition): self
    {
        $this->datePosition = $datePosition;

        return $this;
    }

    public function getDateInsertion(): ?\DateTimeInterface
    {
        return $this->dateInsertion;
    }

    public function setDateInsertion(\DateTimeInterface $dateInsertion): self
    {
        $this->dateInsertion = $dateInsertion;

        return $this;
    }

    public function getParcourt(): ?Parcour
    {
        return $this->parcourt;
    }

    public function setParcourt(?Parcour $parcourt): self
    {
        $this->parcourt = $parcourt;

        return $this;
    }

    public function getAccuracy(): ?float
    {
        return $this->accuracy;
    }

    public function setAccuracy(?float $accuracy): self
    {
        $this->accuracy = $accuracy;

        return $this;
    }

    public function getFromfield(): ?bool
    {
        return $this->fromfield;
    }

    public function setFromfield(?bool $fromfield): self
    {
        $this->fromfield = $fromfield;

        return $this;
    }
}
