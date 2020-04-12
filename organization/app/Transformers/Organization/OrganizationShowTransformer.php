<?php

namespace App\Transformers\Organization;

use League\Fractal\TransformerAbstract;

class OrganizationShowTransformer extends TransformerAbstract
{

    public function transform($organization)
    {
        return [
            'id' => $organization->id,
            'name' => $organization->name,
            'type' => $organization->type,
            'parent' => $organization->parent,
            'created_by' => $organization->createdBy,
            'status' => $organization->status,
            'profile' => $organization->profile,
            'users' => $organization->users
        ];
    }
}
