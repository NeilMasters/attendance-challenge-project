<?php
declare(strict_types=1);

namespace Attendance\Tests\Helpers;

use Attendance\Entity\Student;
use Symfony\Component\Uid\Uuid;

class StudentHelper
{
    public static function getStudent(
        string | null $id = null,
        string $matriculationNumber = 'unimportant',
        string $name = 'Dave Smith'
    ): Student {
        return new Student(
            id: $id ?? (string)Uuid::v4(),
            matriculationNumber: $matriculationNumber,
            name: $name
        );
    }
}