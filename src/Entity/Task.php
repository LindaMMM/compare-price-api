<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ApiResource(
    security: "is_granted('ROLE_USER')",
    description: 'Liste des tâches de recherches',
    normalizationContext: ['groups' => ['read:Tasks', 'read:Task', 'read:Audit']],
    denormalizationContext: ['groups' => ['write:Task']],

    operations: [
        new Get(
            securityMessage: 'Désolé, la tâche ne peut pas être affichée.'
        ),
        new GetCollection(),
        new Post(
            securityMessage: 'Désolé, la tâche peut pas être crée.'
        ),
        new Patch(
            securityMessage: 'Désolé, la tâche ne peut pas être modifiée.'
        ),
        new Delete(
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: 'Désolé, la tâche n\'est pas suprimmable.'
        )
    ]
)]
class Task extends Audit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:Task'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['read:Tasks', 'read:Task', 'write:Task'])]
    #[Assert\NotNull]
    #[Assert\Length(
        min: 3,
        minMessage: 'Le nom doit être supérieur à {{ limit }} charactères de long',
    )]
    private ?string $name = null;

    #[ORM\Column(length: 20)]
    #[Groups(['read:Tasks', 'read:Task', 'write:Task'])]
    #[Assert\NotNull]
    private ?string $frequency = null;

    /**
     * @var Collection<int, Categorie>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'tasks')]
    #[Groups(['read:Task', 'write:Task'])]
    private Collection $category;

    public function __construct()
    {
        parent::__construct();
        $this->category = new ArrayCollection();
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

    public function getFrequency(): ?string
    {
        return $this->frequency;
    }

    public function setFrequency(string $frequency): static
    {
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->category->removeElement($category);

        return $this;
    }
}
