<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private array $Products = [];

    #[ORM\Column]
    private ?bool $approved = null;

    #[ORM\Column(nullable: true)]
    private ?int $price = null;

    #[ORM\Column(nullable: true)]
    private ?int $total_count = null;

    #[ORM\Column(nullable: true)]
    private ?DateTime $approved_at = null;

    /**
     * @return DateTime|null
     */
    public function getApprovedAt(): ?DateTime
    {
        return $this->approved_at;
    }

    /**
     * @param DateTime|null $approved_at
     */
    public function setApprovedAt(?DateTime $approved_at): self
    {
        $this->approved_at = $approved_at;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProducts(): array
    {
        return $this->Products;
    }

    public function setProducts(?array $Products): self
    {
        $this->Products = $Products;

        return $this;
    }

    public function isApproved(): ?bool
    {
        return $this->approved;
    }

    public function setApproved(bool $approved): self
    {
        $this->approved = $approved;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTotalCount(): ?int
    {
        return $this->total_count;
    }

    /**
     * @param int|null $total_count
     */
    public function setTotalCount(?int $total_count): self
    {
        $this->total_count = $total_count;

        return $this;
    }
}
