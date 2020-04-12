<?php

namespace App\Repositories\Contracts;

interface UserRepositoryContract extends BaseRepositoryContract
{
    public function search($params = []);
}
