<?php

use Illuminate\Database\Seeder;
use App\Model\Users;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      factory(Users::class, 3)->create();
    }
}
