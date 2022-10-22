<?php
declare(strict_types=1);

namespace Attendance\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Student implements SaveableInterface
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'string', unique: true)]
        public readonly string $id,
        #[ORM\Column]
        public readonly string $matriculationNumber,
        #[ORM\Column]
        private string $name
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function updateStudentDetails(
        string $name
    ): void {
        $this->name = $name;
    }
}
