<?php
declare(strict_types=1);

namespace Attendance\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class AttendanceRecord implements SaveableInterface
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'string', unique: true)]
        public readonly string $id,
        #[ORM\Column]
        public readonly \DateTime $createdAt,
        #[ORM\ManyToOne(targetEntity: Student::class)]
        public readonly Student $student,
        #[ORM\Column]
        public readonly bool $attended
    ) {
    }
}
