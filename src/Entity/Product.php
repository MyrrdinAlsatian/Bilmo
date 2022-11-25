<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Odm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    paginationItemsPerPage: 3,
    paginationMaximumItemsPerPage: 3,
    paginationClientItemsPerPage: true,
    normalizationContext: [
    'groups' =>["product:read"],
    'jsonld_embed_context' => true])]
#[ApiFilter(OrderFilter::class, properties:[
    'quantity' => 'ASC'
    ])]
#[Get(security: "is_granted('ROLE_USER')")]
#[GetCollection(security: "is_granted('ROLE_USER')")]
#[Post(security: "is_granted('ROLE_ADMIN')")]
#[Delete(security: "is_granted('ROLE_ADMIN')")]
#[Patch(security: "is_granted('ROLE_ADMIN')")]
#[ApiResource(
    description:'Listing des produits d\'une marque',
    uriTemplate: '/brands/{brandId}/products',
    uriVariables: [
        'brandId' => new Link(fromClass:Brand::class, toProperty:'brand')
    ],
    requirements:['brandId'=> '\d+'],
    operations: [new GetCollection(security: "is_granted('ROLE_USER')")],
    normalizationContext:['groups' =>['brand:read']]
)]

    
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    #[Assert\NotBlank]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product:read', 'brand:read'])]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['product:read', 'brand:read'])]
    #[Assert\NotBlank()]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    #[Groups(['product:read', 'brand:read'])]
    #[Assert\NotBlank()]
    private ?string $price = null;

    #[ORM\Column]
    #[Groups(['product:read', 'brand:read'])]
    #[Assert\NotBlank()]
    private ?int $quantity = null;

    #[ORM\Column]
    #[Groups(['product:read', 'brand:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'product')]
    #[Groups(['product:read'])]
    private ?Brand $brand = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }
}
