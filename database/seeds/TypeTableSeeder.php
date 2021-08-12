<?php

use App\Type;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        Type::truncate();

        Schema::enableForeignKeyConstraints();

        $types = [
            "AsianFusion", "Dolci", "Fritti", "Gelato", "Giapponese", "Hamburger", "Insalate", "Italiano", "Kebab", "Panini", "Pizza", "Pollo", "Senza Glutine" 
        ];

        foreach ($types as $type) {
            $newType = new Type();
            $newType->name = $type;
            $newType->slug = Str::slug($type);
            $newType->save();
        }

        $users = User::all();

        if ($users->isEmpty()) {
            $this->call(UserTableSeeder::class);
        }

    }
}
