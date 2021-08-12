<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with("types")->get();

        foreach ($users as $user) {
            $user->link = route("orders.create", ["slug" => $user->slug]);
            $user->cover_UR = $user->cover_UR ? asset('storage/covers/' . $user->id . '/'. $user->cover_UR) : 'https://www.linga.org/site/photos/Largnewsimages/image-not-found.png';
        }

        return response()->json([
            'success' => true,
            'results' => $users
        ]);
    }
}
