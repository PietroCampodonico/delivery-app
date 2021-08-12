<?php

use App\Type;
use App\Order;
use App\Dish;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name("welcome");

Auth::routes();

//Sarà la Dashboard dell'UR
Route::get('/home', 'HomeController@index')->name('home');

//ORDERS UR
Route::post("/orders", "OrderController@store")->name("orders.store");
Route::get("/orders/create/{slug}", "OrderController@create")->name("orders.create");

Route::middleware('auth')
    //->prefix('user/{user}')
    ->group(function () {

        //ORDERS
        Route::get("/orders", "OrderController@index")->name("orders.index");
        Route::get("/orders/{order}", "OrderController@show")->name("orders.show");

        //DISHES
        Route::resource("/dishes", "DishController");
    });

// braintree
Route::post("/payment", function (Request $request) {
    $gateway = new Braintree\Gateway([
        'environment' => config('services.braintree.environment'),
        'merchantId' => config('services.braintree.merchantId'),
        'publicKey' => config('services.braintree.publicKey'),
        'privateKey' => config('services.braintree.privateKey')
    ]);

    $token = $gateway->ClientToken()->generate();

    // prendo i piatti del ristorante
    $restaurant_id = $request->restaurant_id;
    $allRestaurantDishes = Dish::where("user_id", $restaurant_id)->get();

    // validazione quantità
    $request->validate([
        'dishes.*' => 'digits_between:1,99',
    ]);

    // calcolo totale
    // prendo lo slug per poter tornare indietro
    $restaurant = User::where("id", $restaurant_id)->first();
    $restaurantSlug = $restaurant->slug;

    // calcolo il totale
    $amount = 0;
    foreach ($request->dishes as $dish_id => $quantity) {
        $temp = Dish::where("user_id", $restaurant_id)
                    ->where("id", $dish_id)
                    ->first();
        $amount += $temp->price * $quantity;
    }

    if($amount > 0){

        return view("payment", [
            "token" => $token,
            "ordered_dishes" => $request->dishes,
            "allRestaurantDishes" => $allRestaurantDishes,
            "amount" => $amount,
            "restaurantSlug" => $restaurantSlug
        ]);
    } else {
        return back()->withErrors('Il tuo ordine non contiene piatti!');
    }
})->name("payment");


Route::post('/checkout', function (Request $request) {
    $gateway = new Braintree\Gateway([
        'environment' => config('services.braintree.environment'),
        'merchantId' => config('services.braintree.merchantId'),
        'publicKey' => config('services.braintree.publicKey'),
        'privateKey' => config('services.braintree.privateKey')
    ]);

    // $request->validate([
    //     'customer_name' => 'required|max:255',
    //     'customer_mail' => 'required|email:rfc,dns',
    //     'customer_phone_number' => 'required|numeric|max:15',
    //     'delivery_address' => 'required|max:255',
    // ]);

    $amount = $request->amount;
    $nonce = $request->payment_method_nonce;

    $name = $request->customer_name;
    $mail = $request->customer_mail;
    $phone = $request->customer_phone_number;

    $result = $gateway->transaction()->sale([
        'amount' => $amount,
        'paymentMethodNonce' => $nonce,
        'customer' => [
            'firstName' => $name,
            'email' => $mail,
            'phone' => $phone,
        ],
        'options' => [
            'submitForSettlement' => true
        ]
    ]);

    if ($result->success) {

        // immissione dell'orders.store
        $request->validate([
            'delivery_address' => 'required|max:255',
            'customer_mail' => 'required|email:rfc,dns'
        ]);

        $data = $request->all();
        $newOrder = new Order();
        $newOrder->fill($data);

        $newOrder["payment_amount"] = $amount;
        $newOrder["payment_status"] = true;

        $newOrder->save();

        $dishes = collect($request->input('dishes', [])) //colleziona i dati nell'input e li mappa con la...
            ->filter(function ($dish) {
                return !is_Null($dish);
            })
            ->map(function ($dish) {
                return ['quantity' => $dish];  //...terza colonna chiamata nel model Order
            });
        //dd($dishes);
        $newOrder->dishes()->sync($dishes);

        return redirect()->route('payment-successful', ["order" => $newOrder]);
    } else {
        $errorString = "";

        foreach ($result->errors->deepAll() as $error) {
            $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
        }

        return back()->withErrors('An error occurred with the message: ' . $result->message);
    }
})->name("checkout");

Route::get('/payment-successful/{order}', function (Order $order) {
    return view('paymentSuccessful', ["order" => $order]);
})->name("payment-successful");
