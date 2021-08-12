<?php

namespace App\Http\Controllers;

use App\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

//impedisce di accedere alla classe Dish se non registrati------------------

    // public function __construct()
    // {
    //    // $this->middleware('auth');
    // }
//--------------------------------------------------------------------------/

    public function index()
    {
        $dishes = Dish::where('user_id', Auth::user()->id )->get();
        if (!$dishes) {
            abort(404);
        }
            $data = [
                'dishes' => $dishes
            ];
                
        return view ('dishes.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('dishes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'ingredients' => 'required|max:5000',
            'description' => 'required|max:5000',
            'price' => 'required|numeric|between:0,100',
        ]);
        $data = $request->all();
        $newDish = new Dish();
        $newDish->fill($data);
        $newDish->user_id = $request->user()->id;
        $newDish->save();
        
        return redirect()->route('dishes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function show(Dish $dish)
    {
        /*$dish = Dish::findOrFail($id);

        if (is_null($dish)) {
            abort(404);
        }
        return view('dishes.show', ['dish' => $dish]);*/
        
        $user = $dish->user_id;
        if($user != Auth::user()->id) {
            abort(403);
        }

        return view('dishes.show', compact('dish'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Dish $dish)//Dish $dish
    {
        /*$dish = Dish::findOrFail($id);
        $data = [
            'dish' => $dish
        ];

        return view('dishes.edit', $data);*/

        $user = $dish->user_id;
        if ($user != Auth::user()->id) {
            abort(403);
        }

        return view('dishes.edit', compact('dish'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'ingredients' => 'required|max:5000',
            'description' => 'required|max:5000',
            'price' => 'required|numeric|between:0,100', 
        ]);
        $data = $request->all();
        $dish = Dish::findOrFail($id);
        $dish->update($data);

        return redirect()->route('dishes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $dish = Dish::findOrFail($id);
        
        $dish->orders()->detach();
        
        $dish->delete();
        return redirect()->route('dishes.index');
    }
}
