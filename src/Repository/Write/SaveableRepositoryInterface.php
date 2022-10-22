<?php
declare(strict_types=1);

namespace Attendance\Repository\Write;

use Attendance\Entity\SaveableInterface;

interface SaveableRepositoryInterface
{
    public function save(SaveableInterface $saveable): void;
}
