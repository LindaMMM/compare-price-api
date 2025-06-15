<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\RuleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: RuleRepository::class)]
#[ApiResource(
    security: "is_granted('ROLE_USER')",
    description: 'Marque des produits',
    normalizationContext: ['groups' => ['read:Rules', 'read:Rule', 'read:Audit']],
    denormalizationContext: ['groups' => ['write:Rule']],
    operations: [
        new Get(
            securityMessage: 'Désolé, La règle ne peut pas être affichée.'
        ),
        new GetCollection(),
        new Post(
            securityMessage: 'Désolé, La règle peut pas être crée.'
        ),
        new Patch(
            securityMessage: 'Désolé, La règle ne peut pas être modifiée.'
        ),
        new Delete(
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: 'Désolé, La règle ne peut pas être suprimmée.'
        )
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'ensign' => 'exact', 'category' => 'exact'])]

class Rule extends Audit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:Rules'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotNull]
    #[Assert\Length(
        min: 3,
        minMessage: 'Le libellé doit être supérieur à {{ limit }} charactères de long',
    )]
    #[Groups(['read:Rules', 'read:Rule', 'write:Rule'])]
    private ?string $label = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull]
    #[Groups(['read:Rules', 'read:Rule', 'write:Rule'])]
    private ?string $price = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull]
    #[Groups(['read:Rules', 'read:Rule', 'write:Rule'])]
    private ?string $stock = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull]
    #[Groups(['read:Rules', 'read:Rule', 'write:Rule'])]
    private ?string $start = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull]
    #[Groups(['read:Rules', 'read:Rule', 'write:Rule'])]
    private ?string $url = null;

    #[ORM\ManyToOne(inversedBy: 'rules')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:Rules', 'read:Rule', 'write:Rule'])]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'rules')]
    #[Groups(['read:Rules', 'read:Rule', 'write:Rule'])]
    private ?Ensign $ensign = null;

    public function __construct()
    {
        parent::__construct();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): ?string
    {
        return $this->stock;
    }

    public function setStock(string $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getStart(): ?string
    {
        return $this->start;
    }

    public function setStart(string $start): static
    {
        $this->start = $start;

        return $this;
    }
    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getEnsign(): ?Ensign
    {
        return $this->ensign;
    }

    public function setEnsign(?Ensign $ensign): static
    {
        $this->ensign = $ensign;

        return $this;
    }
}
