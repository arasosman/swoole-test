<?php

namespace App\Providers;

use App\Models\Group;
use App\Models\Organization;
use App\Models\OrganizationProfile;
use App\Models\UserProfile;
use App\Repositories\Contracts\GroupRepositoryContract;
use App\Repositories\Contracts\OrganizationProfileRepositoryContract;
use App\Repositories\Contracts\OrganizationRepositoryContract;
use App\Repositories\Contracts\UserProfileRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\GroupRepository;
use App\Repositories\OrganizationProfileRepository;
use App\Repositories\OrganizationRepository;
use App\Repositories\UserProfileRepository;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 * @package App\Providers
 * @SuppressWarnings(PHPMD)
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UserRepositoryContract::class, function () {
            return new UserRepository(new User());
        });
        $this->app->bind(UserProfileRepositoryContract::class, function () {
            return new UserProfileRepository(new UserProfile());
        });
        $this->app->bind(GroupRepositoryContract::class, function () {
            return new GroupRepository(new Group());
        });
        $this->app->bind(OrganizationRepositoryContract::class, function () {
            return new OrganizationRepository(new Organization());
        });
        $this->app->bind(OrganizationProfileRepositoryContract::class, function () {
            return new OrganizationProfileRepository(new OrganizationProfile());
        });
    }
}
