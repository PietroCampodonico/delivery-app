<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use App\Dish;


class DishController extends Controller
{
    public function index()
    {
        $users = User::all();

        foreach ($users as $user) {
          $dishes = Dish::with("users")->where('user_id', $user->id)->get();
        }

        return response()->json([
            'success' => true,
            'results' => $dishes
        ]);
    }
}
