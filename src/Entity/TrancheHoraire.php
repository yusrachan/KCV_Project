<?php

namespace App\Entity;

use App\Repository\TrancheHoraireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrancheHoraireRepository::class)]
class TrancheHoraire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heureDebut = null;

    #[ORM\OneToMany(mappedBy: 'heureDebut', targetEntity: RendezVous::class, orphanRemoval: true)]
    private Collection $rendezVouses;

    #[ORM\ManyToMany(targetEntity: Disponibilite::class, inversedBy: 'trancheDispo')]
    private Collection $dateDisponible;

    public function __construct()
    {
        $this->rendezVouses = new ArrayCollection();
        $this->dateDisponible = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(\DateTimeInterface $heureDebut): static
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    /**
     * @return Collection<int, RendezVous>
     */
    public function getRendezVouses(): Collection
    {
        return $this->rendezVouses;
    }

    public function addRendezVouse(RendezVous $rendezVouse): static
    {
        if (!$this->rendezVouses->contains($rendezVouse)) {
            $this->rendezVouses->add($rendezVouse);
            $rendezVouse->setHeureDebut($this);
        }

        return $this;
    }

    public function removeRendezVouse(RendezVous $rendezVouse): static
    {
        if ($this->rendezVouses->removeElement($rendezVouse)) {
            // set the owning side to null (unless already changed)
            if ($rendezVouse->getHeureDebut() === $this) {
                $rendezVouse->setHeureDebut(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Disponibilite>
     */
    public function getDateDisponible(): Collection
    {
        return $this->dateDisponible;
    }

    public function addDateDisponible(Disponibilite $dateDisponible): static
    {
        if (!$this->dateDisponible->contains($dateDisponible)) {
            $this->dateDisponible->add($dateDisponible);
        }

        return $this;
    }

    public function removeDateDisponible(Disponibilite $dateDisponible): static
    {
        $this->dateDisponible->removeElement($dateDisponible);

        return $this;
    }
}
