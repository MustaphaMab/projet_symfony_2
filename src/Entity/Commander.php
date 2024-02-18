<?php

namespace App\Entity;

use App\Repository\CommanderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: CommanderRepository::class)]
#[Broadcast]
class Commander
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, name: 'Id_livre', referencedColumnName: '$Id_Livre')]
    private ?Livres $Id_Livre = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, name: 'Id_fournisseur', referencedColumnName:'Id_fournisseur')]
    private ?fournisseurs $Id_fournisseur = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_achat = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    private ?string $Prix_achat = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $Nbr_exemplaires = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdLivre(): ?Livres
    {
        return $this->Id_Livre;
    }

    public function setIdLivre(?Livres $Id_Livre): static
    {
        $this->Id_Livre = $Id_Livre;

        return $this;
    }

    public function getIdFournisseur(): ?fournisseurs
    {
        return $this->Id_fournisseur;
    }

    public function setIdFournisseur(?fournisseurs $Id_fournisseur): static
    {
        $this->Id_fournisseur = $Id_fournisseur;

        return $this;
    }

    public function getDateAchat(): ?string
    {
        return $this->Date_achat;
    }

    public function setDateAchat(string $Date_achat): static
    {
        $this->Date_achat = $Date_achat;

        return $this;
    }

    public function getPrixAchat(): ?string
    {
        return $this->Prix_achat;
    }

    public function setPrixAchat(string $Prix_achat): static
    {
        $this->Prix_achat = $Prix_achat;

        return $this;
    }

    public function getNbrExemplaires(): ?string
    {
        return $this->Nbr_exemplaires;
    }

    public function setNbrExemplaires(string $Nbr_exemplaires): static
    {
        $this->Nbr_exemplaires = $Nbr_exemplaires;

        return $this;
    }
}