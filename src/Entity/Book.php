<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[Uploadable]
#[ApiResource(
    normalizationContext: ['groups' => ['book:read']],
    denormalizationContext: ['groups' => ['book:write']],
    types: ['https://schema.org/Book'],
    operations: [
        new GetCollection(),
        new Post(
            outputFormats: ['jsonld' => ['application/ld+json']],
            inputFormats: ['multipart' => ['multipart/form-data']],
        )
    ],
)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['book:write'])]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $filePath = null;

    #[ApiProperty(types: ['https://schema.org/contentUrl'])]
    #[Groups(['book:read'])]
    public ?string $contentUrl = null;

    #[UploadableField(mapping: 'products', fileNameProperty: 'filePath')]
    #[Groups(['book:write'])]
    public ?File $file = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): static
    {
        $this->filePath = $filePath;

        return $this;
    }
}
