<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\SerializedName;
use App\Repository\HistoryRepository;

#[ORM\Entity(repositoryClass: HistoryRepository::class)]
class History
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'json')]
    private string $request;

    #[ORM\Column(type: 'json')]
    private string $response;

    #[ORM\Column(type: 'datetime')]
    #[SerializedName('createdAt')]
    private \DateTimeInterface $createdAt;

    public function __construct(string $request, string $response)
    {
        $this->request = $request;
        $this->response = $response;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRequest(): string
    {
        return $this->request;
    }

    public function getResponse(): string
    {
        return $this->response;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
}