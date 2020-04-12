<?php

namespace App\Repositories;

use App\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Database\Eloquent\Builder;

class UserRepository extends BaseRepository implements UserRepositoryContract
{
    /**
     * @var Builder
     */
    protected $query;

    public function search($params = [])
    {
        $defaultValues = [
            'id' => null,
            'name' => null,
            'language' => null,
            'page' => null,
            'per_page' => 20,
            'with_pagination' => "passive",
            'with' => null,
            'order_by' => "id",
            'order_type' => 'desc'
        ];

        $searchParams = array_filter(array_merge($defaultValues, array_filter($params)));
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
        if (isset($searchParams['language'])) {
            $this->query->where('language', $searchParams['language']);
        }

        $this->query->orderBy($searchParams["order_by"], $searchParams["order_type"]);

        if ($searchParams['with_pagination'] === 'active') {
            return $this->query->paginate($searchParams["per_page"])->appends($searchParams);
        }

        return $this->query->limit($searchParams["per_page"])->get();
    }
}
