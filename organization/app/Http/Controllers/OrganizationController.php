<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationWithProfileRequest;
use App\Repositories\Contracts\OrganizationProfileRepositoryContract;
use App\Repositories\Contracts\OrganizationRepositoryContract;
use App\Repositories\OrganizationProfileRepository;
use App\Repositories\OrganizationRepository;
use App\Transformers\Organization\OrganizationShowTransformer;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class OrganizationController extends Controller
{
    /** @var OrganizationRepositoryContract */
    private $organizationRepository;
    /** @var OrganizationProfileRepository */
    private $organizationProfileRepo;

    public function __construct(OrganizationRepositoryContract $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
        $this->organizationProfileRepo = app(OrganizationProfileRepositoryContract::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index(Request $request)
    {
        $request->merge(['with_server' => ['profile', 'type', 'createdBy', 'parent', 'users']]);
        $organizations = $this->organizationRepository->search($request->all());
        if ($organizations) {
            $response = fractal()
                ->collection($organizations)
                ->transformWith(OrganizationShowTransformer::class);

            if ($request->input('with_pagination') === "active") {
                $response->paginateWith(new IlluminatePaginatorAdapter($organizations));
            }

            return response($response, 200);
        }
        return response('Organizations Empty', 204);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrganizationWithProfileRequest $request
     * @return string
     */
    public function store(OrganizationWithProfileRequest $request)
    {
        $organization = $this->organizationRepository->create($request->all());
        if ($organization) {
            $request->merge(['organization_id' => $organization->id]);
            $this->organizationProfileRepo->create($request->all());
            $response = fractal()
                ->item($organization)
                ->transformWith(OrganizationShowTransformer::class);
            return response($response, 201);
        }
        return response('Organization creating error', 500);
    }

    /**
     * Display the specified resource.
     *
     * @param $organizationId
     * @return Response
     */
    public function show($organizationId)
    {
        $organization = $this->organizationRepository->findWith($organizationId, ['profile', 'type']);
        if ($organization) {
            $response = fractal()
                ->item($organization)
                ->transformWith(OrganizationShowTransformer::class);
            return response($response, 200);
        }
        return response('Organization not found', 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OrganizationWithProfileRequest $request
     * @param $organizationId
     * @return Response
     */
    public function update(OrganizationWithProfileRequest $request, $organizationId)
    {
        $organization = $this->organizationRepository->find($organizationId);
        if ($organization) {
            $updatedOrganization = $this->organizationRepository->update($organization, $request->all());
            if ($updatedOrganization) {
                $response = fractal()
                    ->item($updatedOrganization)
                    ->transformWith(OrganizationShowTransformer::class);

                return response($response, 200);
            }
            return response('Organization update error', 500);
        }
        return response('Organization not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $organizationId
     * @return Response
     */
    public function destroy($organizationId)
    {
        $organization = $this->organizationRepository->find($organizationId);
        if ($organization) {
            $destroyed = $this->organizationRepository->destroy($organization);
            if ($destroyed) {
                return response("Delete Success", 204);
            }
            return response("Delete Fail", 500);
        }
        return response('Organization not found', 404);
    }

    /**
     * @param $organizationId
     * @return ResponseFactory|Response
     */
    public function purge($organizationId)
    {
        $organization = $this->organizationRepository->findIncludingTrashed($organizationId);
        if ($organization) {
            $destroyed = $this->organizationRepository->purge($organization);
            if ($destroyed) {
                return response("Purge Success", 204);
            }
            return response("Purge Fail", 500);
        }
        return response('Organization not found', 404);
    }
}
