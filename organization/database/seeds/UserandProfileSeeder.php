<?php

use Illuminate\Database\Seeder;

class UserandProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class, 10)->create()->each(function ($user) {
            $user->profile()->save(factory(\App\Models\UserProfile::class)->create(['user_id' => $user->id]));
        });
    }
}
