<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AppointmentRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 * collectionOperations={"GET", "POST"},
 * itemOperations={"GET","PATCH","DELETE"},
 * attributes={
 *  "pagination_enabled"=true,
 *  "pagination_items_per_page"=20,
 *  "order":{"date":"desc"}
 * },
 * normalizationContext={"groups"={"appointments_read"}},
 * denormalizationContext={
 *      "disable_type_enforcement"=true,
 *      "groups"={"post_customer_by_appointment"}
 *  }
 * )
 * @ApiFilter(SearchFilter::class)
 * @ApiFilter(OrderFilter::class, properties={"date","status"})
 * @ORM\Entity(repositoryClass=AppointmentRepository::class)
 */
class Appointment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"appointments_read","customers_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"appointments_read","post_customer_by_appointment","customers_read"})
     * @Assert\NotBlank(message="Le status de la facture est obligatoire.")
     * @Assert\Choice(choices={"PENDING","FINISH","CANCELLED"}, message="Le statut doit être PENDING ou FINISH.")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"appointments_read", "post_customer_by_appointment", "customers_read"})
     * @Assert\NotBlank(message="La date du rendez-vous doit être précisée.")
     * @Assert\DateTime(message="La date doit être au format YYYY-MM-DD.")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="appointment", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"appointments_read", "post_customer_by_appointment"})
     * @Assert\NotBlank(message="Le client pour le rendez-vous doit être renseigné.")
     */
    private $customer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}
