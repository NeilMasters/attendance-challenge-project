<?php
declare(strict_types=1);

namespace Attendance\Repository\Write;

use Attendance\Entity\Student;

interface StudentRepositoryInterface extends SaveableRepositoryInterface
{
    public function getByMatriculationNumber(string $matriculationNumber): Student;
}
