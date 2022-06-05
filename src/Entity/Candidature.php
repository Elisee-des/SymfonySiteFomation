<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CandidatureRepository::class)
 */
class Candidature
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $niveauEtude;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCretion;

    /**
     * @ORM\ManyToOne(targetEntity=Formation::class, inversedBy="candidatures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $formation;

    /**
     * @ORM\OneToMany(targetEntity=PieceJointe::class, mappedBy="candidature", orphanRemoval=true)
     */
    private $pieceJointe;

    public function __construct()
    {
        $this->pieceJointe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveauEtude(): ?string
    {
        return $this->niveauEtude;
    }

    public function setNiveauEtude(string $niveauEtude): self
    {
        $this->niveauEtude = $niveauEtude;

        return $this;
    }

    public function getDateCretion(): ?\DateTimeInterface
    {
        return $this->dateCretion;
    }

    public function setDateCretion(\DateTimeInterface $dateCretion): self
    {
        $this->dateCretion = $dateCretion;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * @return Collection<int, PieceJointe>
     */
    public function getPieceJointe(): Collection
    {
        return $this->pieceJointe;
    }

    public function addPieceJointe(PieceJointe $pieceJointe): self
    {
        if (!$this->pieceJointe->contains($pieceJointe)) {
            $this->pieceJointe[] = $pieceJointe;
            $pieceJointe->setCandidature($this);
        }

        return $this;
    }

    public function removePieceJointe(PieceJointe $pieceJointe): self
    {
        if ($this->pieceJointe->removeElement($pieceJointe)) {
            // set the owning side to null (unless already changed)
            if ($pieceJointe->getCandidature() === $this) {
                $pieceJointe->setCandidature(null);
            }
        }

        return $this;
    }

}
