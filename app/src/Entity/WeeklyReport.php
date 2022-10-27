<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DailyReportRepository;
use App\Repository\WeeklyReportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeeklyReportRepository::class)]
#[ApiResource]
class WeeklyReport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'array', nullable: true)]
    private array $orders = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(nullable: true)]
    private ?int $total_count = null;

    #[ORM\Column(nullable: true)]
    private ?int $total_price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrders(): array
    {
        return $this->orders;
    }

    public function setOrders(?array $orders): self
    {
        $this->orders = $orders;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTotalCount(): ?int
    {
        return $this->total_count;
    }

    public function setTotalCount(?int $total_count): self
    {
        $this->total_count = $total_count;

        return $this;
    }

    public function getTotalPrice(): ?int
    {
        return $this->total_price;
    }

    public function setTotalPrice(?int $total_price): self
    {
        $this->total_price = $total_price;

        return $this;
    }
}
