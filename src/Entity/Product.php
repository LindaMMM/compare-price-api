<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiFilter;
use App\Controller\GetStatementController;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    security: "is_granted('ROLE_USER')",
    description: 'Produits recherché',
    normalizationContext: ['groups' => ['read:Products', 'read:Product']],
    denormalizationContext: ['groups' => ['write:Product']],
    forceEager: false,
    paginationMaximumItemsPerPage: 20,
    paginationEnabled: true,
    operations: [
        new Get(
            security: "is_granted('PRODUCT_VIEW', object)",
            securityMessage: 'Désolé, Le produit ne peut pas être affichée.'
        ),
        new GetCollection(),
        new Post(
            security: "is_granted('PRODUCT_EDIT', object)",
            securityMessage: 'Désolé, Le produit peut pas être crée.'
        ),
        new Patch(
            security: "is_granted('PRODUCT_EDIT', object)",
            securityMessage: 'Désolé, Le produit ne peut pas être modifiée.'
        ),
        new Delete(
            security: "is_granted('PRODUCT_DELETE', object)",
            securityMessage: 'Désolé, Le produit ne peut pas être suprimmée.'
        ),
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'nom' => 'partial'])]
class Product extends Audit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:Product', 'read:Statements', 'read:Statements'])]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    #[Groups(['read:Product', 'read:Products', 'write:Product'])]
    private ?string $name = null;

    /**
     * @var list<string> The word search
     */
    #[Groups(['read:Product', 'write:Product'])]
    #[ORM\Column(type: 'json')]
    private array $search = [];


    #[ORM\Column(length: 255)]
    #[Groups(['read:Product', 'write:Product'])]
    private ?string $ref_product = null;

    #[ORM\OneToOne(targetEntity: MediaObject::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'media_id', referencedColumnName: 'id')]
    #[Groups(['read:Product', 'write:Product'])]
    private ?MediaObject  $media = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['read:Product', 'write:Product'])]
    private ?string $content = null;


    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:Product', 'write:Product'])]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[Groups(['read:Product', 'write:Product'])]
    private ?Brand $brand = null;

    /**
     * @var Collection<int, Statement>
     */
    #[ORM\OneToMany(targetEntity: Statement::class, mappedBy: 'product')]
    private Collection $statements;

    public function __construct()
    {
        parent::__construct();
        $this->statements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * 
     *
     * @return list<string>
     */
    public function getSearch(): array
    {
        $search = $this->search;

        return array_unique($search);
    }

    /**
     * @param list<string> $search
     */
    public function setSearchs(array $search): static
    {
        $this->search = $search;

        return $this;
    }


    public function getRefProduct(): ?string
    {
        return $this->ref_product;
    }

    public function setRefProduct(string $ref_product): static
    {
        $this->ref_product = $ref_product;

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

    public function getMedia(): ?MediaObject
    {
        return $this->media;
    }

    public function setMedia(?MediaObject $media): static
    {
        $this->media = $media;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $categorie): static
    {
        $this->category = $categorie;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection<int, Statement>
     */
    public function getstatements(): Collection
    {
        return $this->statements;
    }

    public function addStatement(Statement $statement): static
    {
        if (!$this->statements->contains($statement)) {
            $this->statements->add($statement);
            $statement->setProduct($this);
        }

        return $this;
    }

    public function removeStatement(Statement $statement): static
    {
        if ($this->statements->removeElement($statement)) {
            // set the owning side to null (unless already changed)
            if ($statement->getProduct() === $this) {
                $statement->setProduct(null);
            }
        }

        return $this;
    }
}
