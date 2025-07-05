<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiProperty;
use App\Repository\BrandRepository;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: BrandRepository::class)]
#[ApiResource(

    description: 'Marque des produits',
    normalizationContext: ['groups' => ['read:Brands', 'read:Brand', 'read:Audit']],
    denormalizationContext: ['groups' => ['write:Brand']],
    operations: [
        new Get(
            security: "is_granted('BRAND_VIEW', object)",
            securityMessage: 'Désolé, La marque ne peut pas être affichée.'
        ),
        new GetCollection(),
        new Post(
            security: "is_granted('BRAND_EDIT', object)",
            securityMessage: 'Désolé, La marque ne peut pas être crée.'
        ),
        new Patch(
            security: "is_granted('BRAND_EDIT', object)",
            securityMessage: 'Désolé, La marque ne peut pas être modifiée.'
        ),
        new Delete(
            security: "is_granted('BRAND_DELETE', object)",
            securityMessage: 'Désolé, La marque ne peut pas être suprimmée.'
        )
    ]

)]
#[ApiFilter(SearchFilter::class, properties: [
    'id' => 'exact',
    'name' => 'ipartial'
])]
#[UniqueEntity(
    fields: ['name'],
    message: 'Ce nom existe déjà'
)]
class Brand extends Audit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:Brand'])]
    #[ApiProperty(types: ['http://schema.org/identifier'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank]
    #[Groups(['read:Brand', 'read:Brands', 'write:Brand'])]
    #[Assert\Length(
        min: 3,
        minMessage: 'Le nom de la marque doit être supérieur à {{ limit }} charactères de long',
    )]
    #[ApiProperty(types: ['http://schema.org/name'])]
    private ?string $name = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'brand')]
    private Collection $products;

    public function __construct()
    {
        parent::__construct();
        $this->products = new ArrayCollection();
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
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setBrand($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getBrand() === $this) {
                $product->setBrand(null);
            }
        }

        return $this;
    }
}
