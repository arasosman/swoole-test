<?php

namespace App\Transformers\Organization\Group;

use App\Models\Group;
use League\Fractal\TransformerAbstract;

class GroupTransformer extends TransformerAbstract
{
    public function transform($group)
    {
        return [
            'name' => $group->name,
            'description' => $group->description,
            'type' => $group->type,
            'organization' => $group->organization,
            'created_by' => $group->createdBy
        ];
    }
}
