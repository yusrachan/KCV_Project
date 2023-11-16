<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DisponibiliteRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Ignore;

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
    #[Ignore]
    private ?Kinesitherapeute $kineDispo = null;

    #[ORM\Column(length: 255)]
    private ?string $background_color = null;

    #[ORM\Column(length: 255)]
    private ?string $text_color = null;

    #[ORM\Column(length: 255)]
    private ?string $border_color = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TrancheHoraire $trancheHoraire = null;
    

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
        return $this->background_color;
    }

    public function setBackgroundColor(string $background_color): static
    {
        $this->background_color = $background_color;

        return $this;
    }

    public function getTextColor(): ?string
    {
        return $this->text_color;
    }

    public function setTextColor(string $text_color): static
    {
        $this->text_color = $text_color;

        return $this;
    }

    public function getBorderColor(): ?string
    {
        return $this->border_color;
    }

    public function setBorderColor(string $border_color): static
    {
        $this->border_color = $border_color;

        return $this;
    }

    public function getTrancheHoraire(): ?TrancheHoraire
    {
        return $this->trancheHoraire;
    }

    public function setTrancheHoraire(?TrancheHoraire $trancheHoraire): self
    {
        $this->trancheHoraire = $trancheHoraire;

        return $this;
    }
}
