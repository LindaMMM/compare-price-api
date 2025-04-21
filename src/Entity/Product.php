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

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:Products', 'read:Product']],
    denormalizationContext: ['groups' => ['write:Product']],
    paginationMaximumItemsPerPage: 20,
    paginationEnabled: true
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'nom' => 'partial'])]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:Product'])]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    #[Groups(['read:Product', 'read:Products', 'write:Product'])]
    private ?string $nom = null;


    #[ORM\Column(length: 255)]
    #[Groups(['read:Product', 'write:Product'])]
    private ?string $slug = null;


    #[ORM\Column(length: 255)]
    #[Groups(['read:Product', 'write:Product'])]
    private ?string $ref_marque = null;


    #[ORM\Column]
    #[Groups(['read:Product'])]
    private ?\DateTimeImmutable $createAt = null;


    #[ORM\Column]
    #[Groups(['read:Product'])]
    private ?\DateTimeImmutable $updateAt = null;


    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['read:Product', 'write:Product'])]
    private ?string $content = null;


    #[ORM\ManyToOne(inversedBy: 'Products')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:Product', 'write:Product'])]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'Product')]
    private ?Brand $brand = null;

    /**
     * @var Collection<int, Bank>
     */
    #[ORM\OneToMany(targetEntity: Bank::class, mappedBy: 'Product')]
    private Collection $banks;

    public function __construct()
    {
        $this->createAt =  new \DateTimeImmutable();;
        $this->updateAt =  new \DateTimeImmutable();
        $this->banks = new ArrayCollection();
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategorie(?Category $categorie): static
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
     * @return Collection<int, Bank>
     */
    public function getBanks(): Collection
    {
        return $this->banks;
    }

    public function addBank(Bank $bank): static
    {
        if (!$this->banks->contains($bank)) {
            $this->banks->add($bank);
            $bank->setProduct($this);
        }

        return $this;
    }

    public function removeBank(Bank $bank): static
    {
        if ($this->banks->removeElement($bank)) {
            // set the owning side to null (unless already changed)
            if ($bank->getProduct() === $this) {
                $bank->setProduct(null);
            }
        }

        return $this;
    }
}
