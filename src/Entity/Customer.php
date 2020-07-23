<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CustomerRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 * collectionOperations={"GET"},
 * itemOperations={"GET"},
 * attributes={
 *   "pagination_enabled"=true,
 *   "pagination_items_per_page"=10,
 *   "order":{"lastName":"desc"}
 *  },
 * normalizationContext={
 *  "groups"={"customers_read"}
 * }
 * )
 * @ApiFilter(OrderFilter::class, properties={"lastName"})
 * @ApiFilter(SearchFilter::class)
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"customers_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customers_read"})
     * @Assert\NotBlank(message="Le prénom est obligatoire")
     * @Assert\Length(min=2, max=255, minMessage="Le prénom doit faire entre 2 et 255 caractères.")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customers_read"})
     * @Assert\NotBlank(message="Le nom est obligatoire")
     * @Assert\Length(min=2, max=255, minMessage="Le nom doit faire entre 2 et 255 caractères.")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customers_read"})
     * @Assert\NotBlank(message="L'adresse mail est obligatoire")
     * @Assert\Email(message="Le format de l'adresse mail doit être valide (ex: exemple@mail.com).")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"customers_read"})
     */
    private $company;

    /**
     * @ORM\OneToMany(targetEntity=Appointment::class, mappedBy="customer")
     * @Groups({"customers_read"})
     */
    private $object;

    public function __construct()
    {
        $this->object = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection|Appointment[]
     */
    public function getObject(): Collection
    {
        return $this->object;
    }

    public function addObject(Appointment $object): self
    {
        if (!$this->object->contains($object)) {
            $this->object[] = $object;
            $object->setCustomer($this);
        }

        return $this;
    }

    public function removeObject(Appointment $object): self
    {
        if ($this->object->contains($object)) {
            $this->object->removeElement($object);
            // set the owning side to null (unless already changed)
            if ($object->getCustomer() === $this) {
                $object->setCustomer(null);
            }
        }

        return $this;
    }
}
