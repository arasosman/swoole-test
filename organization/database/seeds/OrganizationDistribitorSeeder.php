<?php

use Illuminate\Database\Seeder;

class OrganizationDistribitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Organization::class, 15000)->create()->each(function ($organization) {
            $organization->profile()->save(factory(\App\Models\OrganizationProfile::class)->create(['organization_id' => $organization->id]));
            $organization->users()->sync(range(10,15));
        });
    }
}
