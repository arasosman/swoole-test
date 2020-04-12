<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Repositories\Contracts\UserProfileRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\UserProfileRepository;
use App\Repositories\UserRepository;
use App\Transformers\Organization\User\UserIndexTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class UserController extends Controller
{
    /** @var UserRepository $userRepository */
    protected $userRepository;
    /** @var UserProfileRepository $userProfileRepository */
    protected $userProfileRepository;

    public function __construct(UserRepositoryContract $userRepository, UserProfileRepositoryContract $userProfileRepository)
    {
        $this->userRepository = $userRepository;
        $this->userProfileRepository = $userProfileRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index(Request $request)
    {
        $request->merge(['with_server' => ['profile', 'organizations', 'distributors', 'clients', 'resellers', 'endusers']]);
        $users = $this->userRepository->search($request->all());
        if ($users) {
            $response = fractal()
                ->collection($users)
                ->transformWith(UserIndexTransformer::class);

            if ($request->input('with_pagination') === "active") {
                $response->paginateWith(new IlluminatePaginatorAdapter($users));
            }

            return response($response, 200);
        }
        return response('Users Empty', 204);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return string
     */
    public function store(UserRequest $request)
    {
        $user = $this->userRepository->create($request->all());
        if ($user) {
            $request->merge(['user_id' => $user->id]);
            $this->userProfileRepository->create($request->all());
            $response = fractal()
                ->item($user)
                ->transformWith(UserIndexTransformer::class);
            return \response($response, 201);
        }
        return \response('User creating error', 500);
    }

    /**
     * Display the specified resource.
     *
     * @param $userId
     * @return string
     */
    public function show($userId)
    {
        $user = $this->userRepository->findWith($userId, ['profile', 'organizations', 'distributors', 'resellers', 'clients', 'endusers']);
        if ($user) {
            $response = fractal()
                ->item($user)
                ->transformWith(UserIndexTransformer::class);
            return response($response, 200);
        }
        return response('User Not found', 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param $userId
     * @return Response
     */
    public function update(UserRequest $request, $userId)
    {
        $user = $this->userRepository->find($userId);
        if ($user) {
            $profile = $this->userProfileRepository->findByAttributes(['user_id' => $userId]);
            if ($profile) {
                $this->userProfileRepository->update($profile, $request->all());
            }
            $updatedProfile = $this->userRepository->update($user, $request->all());
            $response = fractal()
                ->item($updatedProfile)
                ->transformWith(UserIndexTransformer::class);
            return response($response, 200);
        }
        return response('User not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $userId
     * @return Response
     */
    public function destroy($userId)
    {
        $user = $this->userRepository->find($userId);
        if ($user) {
            $result = $this->userRepository->destroy($user);
            if ($result) {
                return response('User delete succes', 200);
            }
            return \response('User delete error', 500);
        }
        return response('User not found', 404);
    }

    public function purge(int $userId)
    {
        $user = $this->userRepository->findIncludingTrashed($userId);
        if ($user) {
            $result = $this->userRepository->purge($user);
            if ($result) {
                return \response('User purge success', 200);
            }
            return \response('User purge error', 500);
        }
        return response('User not found', 404);
    }
}
