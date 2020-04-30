<?php

use App\Models\User;
use App\Model\Review;
use App\Model\Product;
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
        $this->call(CategorySeeder::class);
        factory(User::class, 5)->create();
        factory(Product::class, 50)->create();
        factory(Review::class, 50)->create();

    }
}
