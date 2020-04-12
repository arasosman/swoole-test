<?php

namespace App\Repositories;

use App\Repositories\Contracts\OrganizationRepositoryContract;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Request;

class OrganizationRepository extends BaseRepository implements OrganizationRepositoryContract
{
    /**
     * @var Builder
     */
    protected $query;

    private $type = [
        'distributor' => 1,
        'reseller' => 2,
        'client' => 3,
        'enduser' => 4,
    ];

    public function search($params = [])
    {
        $defaultValues = [
            'id' => null,
            'name' => null,
            'type' => null,
            'type_id' => null,
            'parent_id' => null,
            'status' => 1,
            'email' => null,
            'page' => null,
            'per_page' => 20,
            'with_pagination' => "passive",
            'with' => null,
            'order_by' => "id",
            'order_type' => 'desc'
        ];

        $searchParams = array_filter(array_merge($defaultValues, array_filter($params)));
        $searchParams = $this->appendUser($searchParams);
        if ($searchParams['with_server']) {
            if (!isset($searchParams['with'])) {
                $searchParams['with'] = $searchParams['with_server'];
            }
            $searchParams['with'] = array_merge($searchParams['with_server'], $searchParams['with']);
        }
        $this->query = $this->getModel()->newQuery();
        if (isset($searchParams["with"])) {
            $this->query->with($searchParams["with"]);
        }

        if (isset($searchParams['id'])) {
            $this->query->where('id', $searchParams['id']);
        }
        if (isset($searchParams['name'])) {
            $this->query->where('name', 'like', '%' . $searchParams['name'] . '%');
        }
        if (isset($searchParams['type_id'])) {
            $this->query->where('type_id', $searchParams['type_id']);
        }
        if (isset($searchParams['parent_id'])) {
            $this->query->where('parent_id', $searchParams['parent_id']);
        }
        if (isset($searchParams['status'])) {
            $this->query->where('status', $searchParams['status']);
        }
        if (isset($searchParams['email'])) {
            $this->query->whereHas('profile', function ($query) use ($searchParams) {
                $query->where('email', $searchParams['email']);
            });
        }

        if (isset($searchParams['user'])) {
            $this->query->whereHas('users', function ($query) use ($searchParams) {
                $query->where('users.id', $searchParams['user']);
            });
        }

        $this->query->orderBy($searchParams["order_by"], $searchParams["order_type"]);

        if ($searchParams['with_pagination'] === 'active') {
            return $this->query->paginate($searchParams["per_page"])->appends($searchParams);
        }

        return $this->query->limit($searchParams["per_page"])->get();
    }

    public function appendUser(&$params)
    {
        $user = \Auth::user();
        $payload = \Auth::payload();
        $isServiceSecurity = ($payload->hasKey('service') && $payload['service'] == 'security');

        if (!isset($params['type_id']) && isset($params['type'])) {
            $params['type_id'] = $this->type[$params['type']];
        }

        if ($user->admin) {
            return $params;
        }

        if (!$payload->hasKey('organization_type') && !$isServiceSecurity) {
            throw new AuthenticationException('Organizasyon_type bulunamadı');
        }

        if (!$payload->hasKey('organization_id') && !$isServiceSecurity) {
            throw new AuthenticationException('Organizasyon_id bulunamadı');
        }

        if ($payload->hasKey('organization_type')) {
            if ($payload['organization_type'] == 'distributor') {
                $params['type_id'] = 2;
            }
            if ($payload['organization_type'] == 'reseller') {
                $params['type_id'] = 3;
            }
            if ($payload['organization_type'] == 'client') {
                $params['type_id'] = 4;
            }
            if (!$user->admin) {
                $params['parent_id'] = $payload->get('organization_id');
            }
        }

        return $params;
    }
}
