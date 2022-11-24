<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Driver\Mysqli\Initializer\Secure;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['user']],
    denormalizationContext: ['groups' => ['user', 'user:write']],
    operations:[
            new Delete(security: "is_granted('ROLE_ADMIN')"),
            new Post(security: "is_granted('ROLE_ADMIN')"),
            new Patch(security: "is_granted('ROLE_ADMIN')"),
            new Get(security: "is_granted('ROLE_ADMIN')"),
            new Get(name:'getUserCustomers', uriTemplate: 'users/{id}/customers',
            normalizationContext: ['groups' => ['user_getsubresource_customers']]
        ),
            new GetCollection(security: "is_granted('ROLE_ADMIN')"),        
    ]
)]

// #[ApiResource(
//     uriTemplate: 'users/{id}/customers',
//     operations: [new Get(security: "is_granted('ROLE_USER') or object.id == user")],
//     normalizationContext:['groups' => ['user_getsubresource_customers']]
// )]
// #[ApiResource(
//     description: 'TOTO',
//     normalizationContext:[
//         'groups'=>['user','user:read'],
//         'skip_null_values'=>false]
// )]
// #[ApiResource(operations: [
//     new Post(name: '/whoami', routeName: 'login_check')
// ])]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(["user"])]
    private ?string $email = null;

    #[ORM\Column]
    #[Ignore]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Ignore]
    private ?string $password = null;

    #[ORM\ManyToMany(targetEntity: Customer::class, mappedBy: 'user')]
    #[ORM\JoinTable('customer_user')]
    #[Groups("user_getsubresource_customers")]
    private Collection $customers;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function __construct()
    {
        $this->customers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    #[Ignore()]
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Customer>
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers->add($customer);
            $customer->addUser($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        if ($this->customers->removeElement($customer)) {
            $customer->removeUser($this);
        }

        return $this;
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
}
