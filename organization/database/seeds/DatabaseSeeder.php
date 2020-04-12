<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(UserandProfileSeeder::class);
//        $this->call(OrganizationTypeSeeder::class);
//        $this->call(GroupTypeSeeder::class);
        $this->call(OrganizationDistribitorSeeder::class);
    }
}
