<?php
// api/src/Entity/MediaObject.php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Controller\MediaObjectController;

#[Vich\Uploadable]
#[ORM\Entity]
#[ApiResource(
    normalizationContext: ['groups' => ['media:read']],
    types: ['https://schema.org/MediaObject'],
    operations: [
        new Get(),
        new GetCollection(),
        new Delete(),
        new Post(
            controller: MediaObjectController::class,
            deserialize: false,
            validationContext: ['groups' => ['Default', 'write']],
            openapi: new Model\Operation(
                requestBody: new Model\RequestBody(
                    content: new \ArrayObject([
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary'
                                    ]
                                ]
                            ]
                        ]
                    ])
                )
            )
        )
    ]
)]
class MediaObject
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    #[Groups(['media:read'])]
    private ?int $id = null;

    #[ApiProperty(types: ['https://schema.org/contentUrl'], writable: false)]
    #[Groups(['media:read'])]
    public ?string $contentUrl = null;

    #[Vich\UploadableField(mapping: 'media_object', fileNameProperty: 'filePath')]
    #[Assert\NotNull(groups: ['media:write'])]
    public ?File $file = null;

    #[ApiProperty(writable: false)]
    #[ORM\Column(nullable: true)]
    public ?string $filePath = null;

    #[ORM\Column(length: 50)]
    #[Groups(['media:read', 'media:write'])]
    private ?string $title = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Groups(['media:read', 'media:write'])]
    private ?Product $product = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->title;
    }

    public function setName(string $Name): static
    {
        $this->title = $Name;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $Product): static
    {
        $this->product = $Product;

        return $this;
    }
}
