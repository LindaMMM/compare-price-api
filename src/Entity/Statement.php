<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\StatementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Link;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\GetLastStatementController;

#[ORM\Entity(repositoryClass: StatementRepository::class)]
#[ApiResource(
    security: "is_granted('ROLE_USER')",
    description: 'liste des prix constatés',
    normalizationContext: ['groups' => ['read:Statements', 'read:Statement', 'read:Audit']],
    denormalizationContext: ['groups' => ['write:Statement']],
    forceEager: false,
    paginationMaximumItemsPerPage: 20,
    paginationEnabled: true,
    operations: [
        new Get(
            security: "is_granted('STATEMENT_VIEW', object)",
            securityMessage: 'Désolé, la saisie ne peut pas être affichée.'
        ),
        new GetCollection(),
        new Post(
            security: "is_granted('STATEMENT_EDIT', object)",
            securityMessage: 'Désolé, la saisie peut pas être crée.'
        ),
        new Patch(
            security: "is_granted('STATEMENT_EDIT', object)",
            securityMessage: 'Désolé, la saisie ne peut pas être modifiée.'
        ),
        new Delete(
            security: "is_granted('STATEMENT_DELETE', object)",
            securityMessage: 'Désolé, la saisie ne peut pas être suprimmée.'
        ),
        new GetCollection(
            name: 'products',
            uriTemplate: '/products/{productId}/statements',
            uriVariables: [
                'productId' => new Link(fromClass: Product::class, toProperty: 'product'),
            ]
        ),
        new GetCollection(
            name: 'ensigns',
            uriTemplate: '/ensigns/{ensignId}/product_ensign_statements',
            uriVariables: [
                'ensignId' => new Link(fromClass: Ensign::class, toProperty: 'ensign'),
            ]
        ),
        new GetCollection(
            name: 'products',
            uriTemplate: '/products/{productId}/topstatements',
            controller: GetLastStatementController::class,
            read: false

        )
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'product' => 'exact', 'valid' => 'exact'])]
class Statement extends Audit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:Statements'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:Statements', 'read:Statement', 'write:Statement'])]
    #[Assert\NotNull]
    #[Assert\Url]
    private ?string $url = null;

    #[ORM\ManyToOne(inversedBy: 'statements')]
    #[Groups(['read:Statements', 'read:Statement', 'write:Statement'])]
    #[Assert\NotNull]
    private ?Product $product = null;

    #[ORM\ManyToOne(targetEntity: Ensign::class)]
    #[ORM\JoinColumn(name: 'ensign_id', referencedColumnName: 'id')]
    #[Groups(['read:Statements', 'read:Statement', 'write:Statement'])]
    #[Assert\NotNull]
    private ?Ensign $ensign = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['read:Statements', 'read:Statement'])]
    private ?\DateTimeInterface $dateinput = null;

    #[ORM\Column]
    #[Groups(['read:Statements', 'read:Statement', 'write:Statement'])]
    private ?float $price = null;

    #[ORM\Column]
    #[Groups(['read:Statements', 'read:Statement', 'write:Statement'])]
    private ?int $stock = null;

    #[ORM\Column]
    #[Groups(['read:Statements', 'read:Statement', 'write:Statement'])]
    private ?bool $valid = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:Statement', 'write:Statement'])]
    private ?string $label = null;

    public function getURL(): ?string
    {
        return $this->url;
    }

    public function setURL(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function __construct()
    {
        parent::__construct();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

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
    public function getDateinput(): ?\DateTimeInterface
    {
        return $this->dateinput;
    }

    public function setDateinput(\DateTimeInterface $dateinput): static
    {
        $this->dateinput = $dateinput;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function isValid(): ?bool
    {
        return $this->valid;
    }

    public function setValid(bool $valid): static
    {
        $this->valid = $valid;

        return $this;
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

    #[ORM\PrePersist]
    public function setCreatedAtValue(PrePersistEventArgs $eventArgs): void
    {
        parent::setCreatedAtValue($eventArgs);
        $this->dateinput = new \DateTime();
        if (is_null($this->label)) {
            $this->label = "Aucun commentaire";
        }
    }
}
