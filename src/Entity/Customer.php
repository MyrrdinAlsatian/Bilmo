<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(normalizationContext: [
    // 'groups'=>['user'],
    'jsonld_embed_context' => true])
    ]
#[ApiFilter(SearchFilter::class, properties: [
    'user' => SearchFilter::STRATEGY_EXACT
    ])]

#[ApiResource(
    uriTemplate: '/users/{userId}/customer/{id}',
    uriVariables: [
        'userId' => new Link(fromClass: User::class, toProperty: "user"),
        'id' => new Link(fromClass: Customer::class)
    ],
    operations: [new Get(security: "is_granted('ROLE_USER') or object.getUser() == user")],
    normalizationContext:['groups' => ['user_customer_details']],
)]
#[Get(security:"is_granted('ROLE_USER') or object.getUser() == user" )]
#[Post(security:"is_granted('ROLE_USER') or object.getUser() == user" )]
#[Put(security:"is_granted('ROLE_USER') or object.getUser() == user" )]
#[Patch(security: "is_granted('ROLE_USER') or object.getUser() == user")]
#[Delete(security:"is_granted('ROLE_USER') or object.getUser() == user" )]
#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["user_getsubresource_customers", "user","user_customer_details"])]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["user_getsubresource_customers", "user","user_customer_details"])]
    #[Assert\NotBlank]
    private ?string $forname = null;

    #[ORM\Column(length: 255)]
    #[Groups(["user_getsubresource_customers", "user","user_customer_details"])]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(["user_getsubresource_customers", "user","user_customer_details"])]
    #[Assert\NotBlank]
    private ?string $adress = null;

    #[ORM\Column(length: 255)]
    #[Groups(["user_getsubresource_customers", "user","user_customer_details"])]
    #[Assert\NotBlank]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    #[Groups(["user_getsubresource_customers", "user","user_customer_details"])]
    #[Assert\NotBlank]
    private ?string $country = null;

    #[ORM\Column(length: 255)]
    #[Groups(["user_getsubresource_customers", "user","user_customer_details"])]
    #[Assert\NotBlank]
    private ?string $zipcode = null;

    /** @var Collection<int, User> */
    #[ORM\JoinTable('customer_user')]
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'customers')]
    #[Assert\Valid]
    private Collection $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

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

    public function getForname(): ?string
    {
        return $this->forname;
    }

    public function setForname(string $forname): self
    {
        $this->forname = $forname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->user->removeElement($user);

        return $this;
    }
}
