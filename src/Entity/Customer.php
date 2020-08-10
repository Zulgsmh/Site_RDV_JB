<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CustomerRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 * collectionOperations={"GET","POST"},
 * itemOperations={"GET","DELETE"},
 * subresourceOperations={
 *   "invoices_get_subresource"={"path"="/customers/{id}/invoices"},
 * },
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
     * @Groups({"customers_read","appointments_read","invoices_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customers_read","appointments_read","post_customer_by_appointment","invoices_read"})
     * @Assert\NotBlank(message="Le prénom est obligatoire")
     * @Assert\Length(min=2, max=255, minMessage="Le prénom doit faire entre 2 et 255 caractères.")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customers_read","appointments_read","post_customer_by_appointment","invoices_read"})
     * @Assert\NotBlank(message="Le nom est obligatoire")
     * @Assert\Length(min=2, max=255, minMessage="Le nom doit faire entre 2 et 255 caractères.")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customers_read","appointments_read","post_customer_by_appointment","invoices_read"})
     * @Assert\NotBlank(message="L'adresse mail est obligatoire")
     * @Assert\Email(message="Le format de l'adresse mail doit être valide (ex: exemple@mail.com).")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"customers_read","appointments_read","post_customer_by_appointment","invoices_read"})
     */
    private $company;

    /**
     * @ORM\OneToMany(targetEntity=Appointment::class, mappedBy="customer")
     * @Groups({"customers_read"})
     * @ApiSubresource
     */
    private $appointment;

    /**
     * @ORM\OneToMany(targetEntity=Invoice::class, mappedBy="customer")
     * @Groups({"customers_read"})
     * @ApiSubresource
     */
    private $invoices;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="customers")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"customers_read"})
     */
    private $user;

    public function __construct()
    {
        $this->appointment = new ArrayCollection();
        $this->invoices = new ArrayCollection();
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
    public function getAppointment(): Collection
    {
        return $this->appointment;
    }

    public function addAppointment(Appointment $appointment): self
    {
        if (!$this->appointment->contains($appointment)) {
            $this->appointment[] = $appointment;
            $appointment->setCustomer($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): self
    {
        if ($this->appointment->contains($appointment)) {
            $this->appointment->removeElement($appointment);
            // set the owning side to null (unless already changed)
            if ($appointment->getCustomer() === $this) {
                $appointment->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Invoice[]
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoices(Invoice $invoices): self
    {
        if (!$this->invoices->contains($invoices)) {
            $this->invoices[] = $invoices;
            $invoices->setCustomer($this);
        }

        return $this;
    }

    public function removeInvoices(Invoice $invoices): self
    {
        if ($this->invoices->contains($invoices)) {
            $this->invoices->removeElement($invoices);
            // set the owning side to null (unless already changed)
            if ($invoices->getCustomer() === $this) {
                $invoices->setCustomer(null);
            }
        }

        return $this;
    }

    //Dynamic Data----------------------------------------------------------

    /**
     * Permet de récupérer le total des invoices
     * @Groups({"customers_read"})
     * @return float
     */
    public function getTotalAmount(): float{
        return array_reduce($this->invoices->toArray(), function($total,$invoice){
            return $total + $invoice->getAmount();
        }, 0);
    }
    /**
     * Récupérer le montant qu'il reste à payer
     * @Groups({"customers_read"})
     * @return float
     */
    public function getUnpaidAmount(): float{
        return array_reduce($this->invoices->toArray(), function($total,$invoice){
            return $total + ($invoice->getStatus() === "PAID" || $invoice->getStatus() === "CANCELLED" ? 0 : 
            $invoice->getAmount());
        }, 0);
    }


    //----------------------------------------------------------------------

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
