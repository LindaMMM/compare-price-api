<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiFilter;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:articles', 'read:article']],
    denormalizationContext: ['groups' => ['write:article']],
    paginationMaximumItemsPerPage: 20,
    paginationEnabled: true
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'nom' => 'partial'])]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:article'])]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    #[Groups(['read:article', 'read:articles', 'write:article'])]
    private ?string $nom = null;


    #[ORM\Column(length: 255)]
    #[Groups(['read:article', 'write:article'])]
    private ?string $slug = null;


    #[ORM\Column(length: 255)]
    #[Groups(['read:article', 'write:article'])]
    private ?string $ref_marque = null;


    #[ORM\Column]
    #[Groups(['read:article'])]
    private ?\DateTimeImmutable $createAt = null;


    #[ORM\Column]
    #[Groups(['read:article'])]
    private ?\DateTimeImmutable $updateAt = null;


    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['read:article', 'write:article'])]
    private ?string $content = null;


    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:article', 'write:article'])]
    private ?Categorie $categorie = null;

    public function __construct()
    {
        $this->createAt =  new \DateTimeImmutable();;
        $this->updateAt =  new \DateTimeImmutable();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getRefMarque(): ?string
    {
        return $this->ref_marque;
    }

    public function setRefMarque(string $ref_marque): static
    {
        $this->ref_marque = $ref_marque;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateA(\DateTimeImmutable $creele): static
    {
        $this->createAt = $creele;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeImmutable $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
}
