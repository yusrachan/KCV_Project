<?php

namespace App\Entity;

use App\Repository\DisponibiliteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DisponibiliteRepository::class)]
class Disponibilite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDisponible = null;

    #[ORM\ManyToMany(targetEntity: TrancheHoraire::class, mappedBy: 'dateDisponible')]
    private Collection $trancheDispo;

    #[ORM\ManyToOne(inversedBy: 'dateDispo')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Kinesitherapeute $kineDispo = null;

    #[ORM\Column(length: 255)]
    private ?string $backgroundColor = null;

    public function __construct()
    {
        $this->trancheDispo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDisponible(): ?\DateTimeInterface
    {
        return $this->dateDisponible;
    }

    public function setDateDisponible(\DateTimeInterface $dateDisponible): static
    {
        $this->dateDisponible = $dateDisponible;

        return $this;
    }

    /**
     * @return Collection<int, TrancheHoraire>
     */
    public function getTrancheDispo(): Collection
    {
        return $this->trancheDispo;
    }

    public function addTrancheDispo(TrancheHoraire $trancheDispo): static
    {
        if (!$this->trancheDispo->contains($trancheDispo)) {
            $this->trancheDispo->add($trancheDispo);
            $trancheDispo->addDateDisponible($this);
        }

        return $this;
    }

    public function removeTrancheDispo(TrancheHoraire $trancheDispo): static
    {
        if ($this->trancheDispo->removeElement($trancheDispo)) {
            $trancheDispo->removeDateDisponible($this);
        }

        return $this;
    }

    public function getKineDispo(): ?Kinesitherapeute
    {
        return $this->kineDispo;
    }

    public function setKineDispo(?Kinesitherapeute $kineDispo): static
    {
        $this->kineDispo = $kineDispo;

        return $this;
    }

    public function getBackgroundColor(): ?string
    {
        return $this->backgroundColor;
    }

    public function setBackgroundColor(string $backgroundColor): static
    {
        $this->backgroundColor = $backgroundColor;

        return $this;
    }
}
