<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Symfony\Action\NotFoundAction;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:Category', 'read:Categories']],
    denormalizationContext: ['groups' => ['write:Category']],
    paginationMaximumItemsPerPage: 20,
    paginationEnabled: true
)]
class Category extends Audit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:Product', 'write:Product', 'read:Category', 'write:Category'])]
    private ?int $id = null;

    #[Groups(['read:Product', 'write:Product', 'read:Category', 'write:Category', 'read:Categoryies'])]
    #[ORM\Column(length: 255)]
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
