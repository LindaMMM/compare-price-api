<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Symfony\Action\NotFoundAction;
use ApiPlatform\Metadata\ApiProperty;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource(
    description: 'Categorie des produits',
    security: "is_granted('ROLE_USER')",
    normalizationContext: ['groups' => ['read:Category', 'read:Categories']],
    denormalizationContext: ['groups' => ['write:Category']],
    operations: [
        new Get(
            security: "is_granted('CATEGORY_VIEW', object)",
            securityMessage: 'Désolé, La catégorie ne peut pas être affiché.'
        ),
        new GetCollection(),
        new Post(
            security: "is_granted('CATEGORY_EDIT', object)",
            securityMessage: 'Désolé, La catégorie ne peut pas être créé.'
        ),
        new Patch(
            security: "is_granted('CATEGORY_EDIT', object)",
            securityMessage: 'Désolé, La catégorie ne peut pas être modifié.'
        ),
        new Delete(
            security: "is_granted('CATEGORY_DELETE', object)",
            securityMessage: 'Désolé, La catégorie ne peut pas être suprimmé.'
        ),
    ]
)]
#[UniqueEntity(
    fields: ['name'],
    message: 'Ce nom existe déjà'
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'tasks' => 'partial'])]
#[ApiFilter(OrderFilter::class, properties: [
    'id' => 'ASC',
    'name' => 'ASC'
])]
class Category extends Audit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ApiProperty(types: ['http://schema.org/identifier'])]
    #[Groups(['read:Product', 'write:Product', 'read:Category', 'write:Category', 'read:Tasks'])]
    private ?int $id = null;

    #[Groups(['read:Product', 'write:Product', 'read:Category', 'write:Category', 'read:Categoryies'])]
    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotNull]
    #[Assert\Length(
        min: 3,
        minMessage: 'Le nom de la catégorie doit être supérieur à {{ limit }} charactères de long',
    )]
    #[ApiProperty(types: ['http://schema.org/name'])]
    private ?string $name = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'category')]
    private Collection $products;

    /**
     * @var Collection<int, Task>
     */
    #[ORM\ManyToMany(targetEntity: Task::class, mappedBy: 'category')]
    private Collection $tasks;

    /**
     * @var Collection<int, Rule>
     */
    #[ORM\OneToMany(targetEntity: Rule::class, mappedBy: 'category')]
    private Collection $rules;

    public function __construct()
    {
        parent::__construct();
        $this->products = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->rules = new ArrayCollection();
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
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $Product): static
    {
        if ($this->products->removeElement($Product)) {
            // set the owning side to null (unless already changed)
            if ($Product->getCategory() === $this) {
                $Product->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): static
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->addCategory($this);
        }

        return $this;
    }

    public function removeTask(Task $task): static
    {
        if ($this->tasks->removeElement($task)) {
            $task->removeCategory($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Rule>
     */
    public function getRules(): Collection
    {
        return $this->rules;
    }

    public function addRule(Rule $rule): static
    {
        if (!$this->rules->contains($rule)) {
            $this->rules->add($rule);
            $rule->setCategory($this);
        }

        return $this;
    }

    public function removeRule(Rule $rule): static
    {
        if ($this->rules->removeElement($rule)) {
            // set the owning side to null (unless already changed)
            if ($rule->getCategory() === $this) {
                $rule->setCategory(null);
            }
        }

        return $this;
    }
}
