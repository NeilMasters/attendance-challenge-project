<?php
declare(strict_types=1);

namespace Attendance\Exception\Student;

final class StudentNotFoundByMatriculationNumber extends StudentNotFound
{
    public function __construct(string $matriculationNumber)
    {
        parent::__construct(sprintf('by matriculation number %s', $matriculationNumber));
    }
}
