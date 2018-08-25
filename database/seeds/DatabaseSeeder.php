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
		// $this->call(UsersTableSeeder::class);
		//factory(App\Saude::class, 10)->create()->each(function ($u) {
		//	$u->posts()->save(factory(App\Post::class)->make());
		//});
		factory(App\Saude::class,'eins', 11)->create();
    }
}
