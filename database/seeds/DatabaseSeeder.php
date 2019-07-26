<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $userCount = 5;
        for ($i = 0; $i < $userCount; $i++) {
            $user = factory(\App\User::class)->make();
            $user->save();
            for ($j = 0; $j < $userCount; $j++) {
                $ink = factory(\App\Ink::class)->make();
                $ink->user_id = $user->id;
                $ink->save();
                $media = factory(\App\Media::class)->make();
                $media->ink_id = $ink->id;
                $media->save();
            }
        }
    }
}
