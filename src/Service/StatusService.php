<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\StatusInterface;

class StatusService
{
    public const TODO = 'TODO';

    public const DOING = 'DOING';

    public const DONE = 'DONE';

    public function validateStatus(StatusInterface $object)
    {
        $status = $object->getStatus();
        if (strcasecmp(gettype($status), 'string') !== 0) {
            return false;
        }

        $statuses = (new \ReflectionClass($this))->getConstants();
        if (array_key_exists($status, $statuses)) {
            return true;
        }

        return false;
    }
}