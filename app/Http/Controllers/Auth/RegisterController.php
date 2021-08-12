<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Type;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'types' => 'present|array',
            'address' => ['required', 'string'],
            'VAT' => ['required', 'string', 'size:11', 'unique:users']
        ]);
    }

    public function showRegistrationForm()
    {
        $types = Type::all();
        return view('auth.register', ['types' => $types]); 
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {      

        $slug = Str::slug($data["name"]);

        $slugTemp = $slug;
        $slugExists = User::where("slug", $slug)->first();
        $counter = 1;

        while($slugExists) {
            $slug = $slugTemp . "-" . $counter;
            $counter++;
            $slugExists = User::where("slug", $slug)->first();
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),            
            'address' => $data["address"],
            'VAT' => $data["VAT"],
            'slug' => $slug
        ]);

        if (request()->hasFile('cover_UR')){
            $cover_UR = request()->file('cover_UR')->getClientOriginalName();
            request()->file('cover_UR')->storeAs('covers', $user->id.'/'. $cover_UR, '');
            $user->update(['cover_UR'=>$cover_UR]);
        }

        $user->types()->sync($data["types"]);

        return $user;
    }
}
