<?php

namespace App\Serializer;

use App\Entity\TODO;

class ApiSerializer
{
    public function serializeTODO(TODO $TODO)
    {
        return [
            'name' => $TODO->getName(),
            'description' => $TODO->getDescription(),
            'datetime' => $TODO->getDatetime(),
            'status' => $TODO->getStatus(),
            'assignedTo' => $TODO->getAssignedTo(),
        ];
    }
}
