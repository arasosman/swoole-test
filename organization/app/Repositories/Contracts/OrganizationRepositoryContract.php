<?php

namespace App\Repositories\Contracts;

interface OrganizationRepositoryContract extends BaseRepositoryContract
{
    public function search($params = []);
}
