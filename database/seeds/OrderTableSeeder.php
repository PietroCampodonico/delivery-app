<?php

use App\Dish;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        /*Schema::disableForeignKeyConstraints();

        Order::truncate();
        DB::table('dish_order')->truncate();

        Schema::enableForeignKeyConstraints();*/

        factory(App\Order::class, 50)->create();

        $dishes = Dish::all(); 

        if($dishes->isEmpty()) {
            $this->call(DishTableSeeder::class);
        }

        $dishesIDs = DB::table('dishes')->pluck('id');
        $ordersIDs = DB::table('orders')->pluck('id');

        foreach (range(1, 50) as $index) {
            DB::table('dish_order')->insertOrIgnore([
                'dish_id' => $faker->randomElement($dishesIDs),
                'order_id' => $faker->randomElement($ordersIDs),
                'quantity' => rand(1,5),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
