<?php

use App\Type;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        /*Schema::disableForeignKeyConstraints();
        
        User::truncate();
        DB::table('type_user')->truncate();
        
        Schema::enableForeignKeyConstraints();*/
        
        $types = Type::all();
        
        if ($types->isEmpty()) {
            $this->call(TypeTableSeeder::class);
        }
        
        $restaurantName = ['Fratelli La Bufala', 'Road House', 'Da Sahid', 'Haochi Canguan', 'Tenji', 'Il Fornello',
        'Osteria dei Servi', 'I Gelsi', 'Carpe Diem', 'La Brace', 'Puccetteria', 'PokeHouse', 'Delifrance', 'Battistini',
        'Giusto Spirito', 'Meat', 'Mosquito', 'Caracol', 'Da Walter', 'Pizzeria Paradiso', 'I Tramonti', 'Casa Matta',
        'Fortuna Rosa Albicocca', 'Il Gelsomino', 'Da Gelia'];


        for($i = 0; $i < 10; $i++) {
            $randomRestaurantName = $restaurantName[rand(0, count($restaurantName) - 1)];
    
            $slug = Str::slug($randomRestaurantName);
            $slugTemp = $slug;
            $slugExists = User::where("slug", $slug)->first();
    
            $counter = 1;
            
            while ($slugExists) {
                $slug = $slugTemp . "-" . $counter;
                $counter++;
                $slugExists = User::where("slug", $slug)->first();
            }
            
            $newUser = new User();
            $newUser->name = $randomRestaurantName;
            
            $newUser->email = $faker->unique()->safeEmail;
            $newUser->email_verified_at = now();
            $newUser->password = Hash::make("12345678");//$faker->password(8,20);//'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            $newUser->remember_token = Str::random(10);
    
            $newUser->address = $faker->address();
            $newUser->VAT = strval(rand(0,9)).strval(random_int(1000000000,2147483647));
            $newUser->slug = $slug;
            $newUser->save();
        }

        $usersIDs = DB::table('users')->pluck('id');
        $typesIDs = DB::table('types')->pluck('id');

        foreach (range(1,25) as $index) {
            DB::table('type_user')->insertOrIgnore([
                'user_id' => $faker->randomElement($usersIDs),
                'type_id' => $faker->randomElement($typesIDs),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
