<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequest;
use App\Repositories\Contracts\GroupRepositoryContract;
use App\Transformers\Organization\Group\GroupTransformer;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class GroupController extends Controller
{
    /** @var GroupRepositoryContract */
    protected $groupRepository;

    public function __construct()
    {
        $this->groupRepository = app(GroupRepositoryContract::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        $groups = $this->groupRepository->allWith(['type', 'createdBy', 'organization']);
        if ($groups) {
            $response = fractal()
                ->collection($groups)
                ->transformWith(GroupTransformer::class);
            return response($response, 200);
        }
        return response('Groups Empty', 204);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GroupRequest $request
     * @return string
     */
    public function store(GroupRequest $request)
    {
        $group = $this->groupRepository->create($request->all());
        if ($group) {
            $response = fractal()
                ->item($group)
                ->transformWith(GroupTransformer::class);
            return response($response, 201);
        }
        return response('Group creating error', 500);
    }

    /**
     * Display the specified resource.
     *
     * @param integer $groupId
     * @return string
     */
    public function show(int $groupId)
    {
        $group = $this->groupRepository->findWith($groupId, ['type', 'organization']);
        if ($group) {
            $response = fractal()
                ->item($group)
                ->transformWith(GroupTransformer::class);
            return response($response, 200);
        }
        return response('Group not found', 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GroupRequest $request
     * @param int $groupId
     * @return string
     */
    public function update(GroupRequest $request, int $groupId)
    {
        $group = $this->groupRepository->find($groupId);
        if ($group) {
            $updatedGroup = $this->groupRepository->update($group, $request->all());
            if ($updatedGroup) {
                $response = fractal()
                    ->item($updatedGroup)
                    ->transformWith(GroupTransformer::class);
                return response($response, 200);
            }
            return response('Group update error', 500);
        }

        return response('Group not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $groupId
     * @return Response
     */
    public function destroy($groupId)
    {
        $group = $this->groupRepository->find($groupId);
        if ($group) {
            $destroyed = $this->groupRepository->destroy($group);
            if ($destroyed) {
                return response("Delete Success", 204);
            }
            return response("Delete Fail", 500);
        }
        return response('Group not found', 404);
    }

    /**
     * @param $groupId
     * @return ResponseFactory|Response|mixed
     */
    public function purge($groupId)
    {
        $group = $this->groupRepository->findIncludingTrashed($groupId);
        if ($group) {
            $destroyed = $this->groupRepository->purge($group);
            if ($destroyed) {
                return response("Purge Success", 204);
            }
            return response("Purge Fail", 500);
        }
        return response('Group not found', 404);
    }
}
