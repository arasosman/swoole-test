<?php

namespace App\Transformers\Organization\User;

use League\Fractal\TransformerAbstract;

class UserIndexTransformer extends TransformerAbstract
{
    public function transform($user)
    {
        return [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'language' => $user->language,
            'profile' => $user->profile,
            'organizations' => $user->organizations,
            'distributors' => $user->distributors,
            'resellers' => $user->resellers,
            'clients' => $user->clients,
            'endusers' => $user->endusers
        ];
    }
}
