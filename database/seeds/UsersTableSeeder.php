<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            factory(User::class)->create([
                'name'    => 'Test',
                'surname' => 'User',
                'email'   => 'test@test.com',
            ]);
        } catch (PDOException $e) {
            dump("PDOException: SQLSTATE[{$e->getCode()}] Ignored - \"test@test.com\" already exists.");
        }

        try {
            factory(User::class, 200)->create()->each(function ($s) {
                //$s->boards()->create([
                //    'name' => __('board.Introduction Board'),
                //    'description' => __('board.Introduction Board Description'),
                //]);
            });
        } catch (PDOException $e) {
            dump("PDOException: SQLSTATE[{$e->getCode()}] Ignored");
        }
    }
}
