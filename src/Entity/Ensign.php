<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;

use App\Repository\EnsignRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EnsignRepository::class)]
#[ApiResource(
    security: "is_granted('ROLE_USER')",
    description: 'Enseigne de recherche de prix',
    normalizationContext: ['groups' => ['read:Ensign', 'read:Ensigns']],
    denormalizationContext: ['groups' => ['write:Ensign']],
    operations: [
        new Get(
            security: "is_granted('ENSIGN_VIEW', object)",
            securityMessage: 'Désolé, L\'enseigne ne peut pas être affichée.'
        ),
        new GetCollection(),
        new Post(
            security: "is_granted('ENSIGN_EDIT', object)",
            securityMessage: 'Désolé, L\'enseigne peut pas être crée.'
        ),
        new Patch(
            security: "is_granted('ENSIGN_EDIT', object)",
            securityMessage: 'Désolé, L\'enseigne ne peut pas être modifiée.'
        ),
        new Delete(
            security: "is_granted('ENSIGN_DELETE', object)",
            securityMessage: 'Désolé, L\'enseigne ne peut pas être suprimmée.'
        )
    ]
)]
#[UniqueEntity(
    fields: ['name'],
    message: 'Ce nom existe déjà'
)]
class Ensign extends Audit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:Ensign', 'write:Ensign', 'read:Ensigns'])]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Groups(['read:Ensign', 'write:Ensign', 'read:Ensigns'])]
    #[Assert\NotNull]
    #[Assert\Length(
        min: 3,
        minMessage: 'Le nom de L\'enseigne doit être supérieur à {{ limit }} charactères de long',
    )]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:Ensign', 'write:Ensign', 'read:Ensigns'])]
    #[Assert\NotNull]
    #[Assert\Url(message: 'Cette url {{ value }} n\'est pas valide.')]
    private ?string $url = null;

    /**
     * @var Collection<int, Rule>
     */
    #[ORM\OneToMany(targetEntity: Rule::class, mappedBy: 'ensign')]
    private Collection $rules;


    public function __construct()
    {
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

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
            $rule->setEnsign($this);
        }

        return $this;
    }

    public function removeRule(Rule $rule): static
    {
        if ($this->rules->removeElement($rule)) {
            // set the owning side to null (unless already changed)
            if ($rule->getEnsign() === $this) {
                $rule->setEnsign(null);
            }
        }

        return $this;
    }
}
