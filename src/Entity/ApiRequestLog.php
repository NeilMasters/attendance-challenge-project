<?php
declare(strict_types=1);

namespace Attendance\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ApiRequestLog
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'string', unique: true)]
        private readonly string $id,
        #[ORM\Column]
        private readonly \DateTime $createdAt,
        #[ORM\Column]
        private readonly string $url,
        #[ORM\Column(type: 'text')]
        private readonly string $requestBody
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getRequestBody(): string
    {
        return $this->requestBody;
    }
}
