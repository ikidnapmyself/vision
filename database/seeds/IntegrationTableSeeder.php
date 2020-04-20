<?php

use App\Models\Integration;
use App\Models\User;
use Illuminate\Database\Seeder;

class IntegrationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function ($item) {
            factory(Integration::class)->create([
                'user_id' => $item->id,
            ]);
        });
    }
}
