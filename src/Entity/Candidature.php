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

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="candidatures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fichiers;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    public function __construct()
    {
        $this->pieceJointe = new ArrayCollection();
        $this->dateCretion = new \DateTime();
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFichiers(): ?string
    {
        return $this->fichiers;
    }

    public function setFichiers(string $fichiers): self
    {
        $this->fichiers = $fichiers;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

}
