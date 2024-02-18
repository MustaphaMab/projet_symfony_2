<?php

namespace App\Entity;

use App\Repository\LivresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use function PHPSTORM_META\type;

#[ORM\Entity(repositoryClass: LivresRepository::class)]
class Livres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'Id_Livre')]
    private ?int $Id_Livre = null;

    #[ORM\Column(length: 50)]
    private ?string $isbn = null;

    #[ORM\Column(length: 100)]
    private ?string $titre_livre = null;

    #[ORM\Column(length: 50)]
    private ?string $theme_livre = null;

    #[ORM\Column(type: Types::BIGINT,)]
    private ?int $nbr_pages_livre = null;

    #[ORM\Column(length: 100)]
    private ?string $format_livre = null;

    #[ORM\Column(length: 100)]
    private ?string $nom_auteur = null;

    #[ORM\Column(length: 100)]
    private ?string $prenom_auteur = null;

    #[ORM\Column(length: 100)]
    private ?string $editeur = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '2')]
    private ?string $prix_vente = null;

    #[ORM\Column(length: 100)]
    private ?string $langue_livre = null;

    #[ORM\OneToMany(targetEntity: Commander::class, mappedBy: 'Id_Livre')]
    private Collection $commanders;

    public function __construct()
    {
        $this->commanders = new ArrayCollection();
    }

 
    
    

        public function getId(): ?int
    {
        return $this->Id_Livre;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getTitreLivre(): ?string
    {
        return $this->titre_livre;
    }

    public function setTitreLivre(string $titre_livre): static
    {
        $this->titre_livre = $titre_livre;

        return $this;
    }

    public function getThemeLivre(): ?string
    {
        return $this->theme_livre;
    }

    public function setThemeLivre(string $theme_livre): static
    {
        $this->theme_livre = $theme_livre;

        return $this;
    }

    public function getNbrPagesLivre(): ?int
    {
        return $this->nbr_pages_livre;
    }

    public function setNbrPagesLivre(int $nbr_pages_livre): static
    {
        $this->nbr_pages_livre = $nbr_pages_livre;

        return $this;
    }


    public function getFormatLivre(): ?string
    {
        return $this->format_livre;
    }

    public function setFormatLivre(string $format_livre): static
    {
        $this->format_livre = $format_livre;

        return $this;
    }

    public function getNomAuteur(): ?string
    {
        return $this->nom_auteur;
    }

    public function setNomAuteur(string $nom_auteur): static
    {
        $this->nom_auteur = $nom_auteur;

        return $this;
    }

    public function getPrenomAuteur(): ?string
    {
        return $this->prenom_auteur;
    }

    public function setPrenomAuteur(string $prenom_auteur): static
    {
        $this->prenom_auteur = $prenom_auteur;

        return $this;
    }

    public function getEditeur(): ?string
    {
        return $this->editeur;
    }

    public function setEditeur(string $editeur): static
    {
        $this->editeur = $editeur;

        return $this;
    }

    public function getPrixVente(): ?string
    {
        return $this->prix_vente;
    }

    public function setPrixVente(string $prix_vente): static
    {
        $this->prix_vente = $prix_vente;

        return $this;
    }

    public function getLangueLivre(): ?string
    {
        return $this->langue_livre;
    }

    public function setLangueLivre(string $langue_livre): static
    {
        $this->langue_livre = $langue_livre;

        return $this;
    }

    /**
     * @return Collection<int, Commander>
     */
    public function getCommanders(): Collection
    {
        return $this->commanders;
    }

    public function addCommander(Commander $commander): static
    {
        if (!$this->commanders->contains($commander)) {
            $this->commanders->add($commander);
            $commander->setIdLivre($this);
        }

        return $this;
    }

    public function removeCommander(Commander $commander): static
    {
        if ($this->commanders->removeElement($commander)) {
            // set the owning side to null (unless already changed)
            if ($commander->getIdLivre() === $this) {
                $commander->setIdLivre(null);
            }
        }

        return $this;
    }


       
}