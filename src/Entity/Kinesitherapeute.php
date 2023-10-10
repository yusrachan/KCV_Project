<?php

namespace App\Entity;

use App\Repository\KinesitherapeuteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KinesitherapeuteRepository::class)]
class Kinesitherapeute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'kineDispo', targetEntity: Disponibilite::class, orphanRemoval: true)]
    private Collection $dateDispo;

    public function __construct()
    {
        $this->dateDispo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Disponibilite>
     */
    public function getDateDispo(): Collection
    {
        return $this->dateDispo;
    }

    public function addDateDispo(Disponibilite $dateDispo): static
    {
        if (!$this->dateDispo->contains($dateDispo)) {
            $this->dateDispo->add($dateDispo);
            $dateDispo->setKineDispo($this);
        }

        return $this;
    }

    public function removeDateDispo(Disponibilite $dateDispo): static
    {
        if ($this->dateDispo->removeElement($dateDispo)) {
            // set the owning side to null (unless already changed)
            if ($dateDispo->getKineDispo() === $this) {
                $dateDispo->setKineDispo(null);
            }
        }

        return $this;
    }
}
