<?php

namespace App\Model;

use DateTime;

class OrderModel
{
    private ?int $id = null;

    private array $Products = [];

    private ?bool $approved = null;

    private ?int $price = null;

    private ?int $total_count = null;

    private ?DateTime $approved_at = null;
    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->Products;
    }


    public function setProducts(array $Products): void
    {
        $this->Products = $Products;
    }

    /**
     * @return bool|null
     */
    public function getApproved(): ?bool
    {
        return $this->approved;
    }

    /**
     * @param bool|null $approved
     */
    public function setApproved(?bool $approved): void
    {
        $this->approved = $approved;
    }

    /**
     * @return int|null
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param int|null $price
     */
    public function setPrice(?int $price): void
    {
        $this->price = $price;
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
    public function setTotalCount(?int $total_count): void
    {
        $this->total_count = $total_count;
    }

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
    public function setApprovedAt(?DateTime $approved_at): void
    {
        $this->approved_at = $approved_at;
    }

}