<?php


namespace App\Http\Controllers;

use App\Dish;
use App\Order;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use function PHPSTORM_META\map;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $orders = DB::table("orders")
            ->join("dish_order", "id", "=", "dish_order.order_id")
            ->join("dishes", "dish_id", "=", "dishes.id")
            ->join("users", "dishes.user_id", "=", "users.id")
            ->select("orders.*")
            ->groupBy("orders.id")
            ->where("user_id", $user_id)
            ->orderBy("orders.created_at", "desc")
            ->get();

        // dati per i grafici
        $months = ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"];
       
        $existingOrdersYears = DB::table('orders')
            ->join("dish_order", "id", "=", "dish_order.order_id")
            ->join("dishes", "dish_id", "=", "dishes.id")
            ->join("users", "dishes.user_id", "=", "users.id")
            ->select("orders.*")
            ->groupBy("orders.id")
            ->where("user_id", $user_id)
            ->pluck('orders.created_at')
            ->toArray();

        $ordersYearsToString = array_map('strtotime' ,$existingOrdersYears);
        $yearsToSort = [];    

        for ($i = 0; $i < count($ordersYearsToString); $i++) {
            $orderYear = date('Y', $ordersYearsToString[$i]);

            if(!in_array($orderYear,$yearsToSort)) {
            $yearsToSort[] = $orderYear;
            }
        }

        $years = collect($yearsToSort)->sort()->values()->all();
      
        // dump($years);
        // return;
        
        //$years = ["2020", "2021"];

        $ordersByYear = [];
        $profitByYear = [];
        foreach($years as $key => $value) {
            $temp = DB::table("orders")
            ->join("dish_order", "id", "=", "dish_order.order_id")
            ->join("dishes", "dish_id", "=", "dishes.id")
            ->join("users", "dishes.user_id", "=", "users.id")
            ->select("orders.*")
            ->groupBy("orders.id")
            ->where("user_id", $user_id)
            ->where(DB::raw("DATE_FORMAT(orders.created_at, '%Y')"),$value)
            ->get();

            $count = 0;
            $total = 0;
            foreach($temp as $k => $v) {
                $count++;
                $total += $v->payment_amount;
            }
            $ordersByYear[] = $count;
            $profitByYear[] = $total;
        };

        $ordersByMonth = [];
        $profitByMonth = [];
        foreach($months as $key => $value) {
            $temp = DB::table("orders")
            ->join("dish_order", "id", "=", "dish_order.order_id")
            ->join("dishes", "dish_id", "=", "dishes.id")
            ->join("users", "dishes.user_id", "=", "users.id")
            ->select("orders.*")
            ->groupBy("orders.id")
            ->where("user_id", $user_id)
            ->where(DB::raw("DATE_FORMAT(orders.created_at, '%Y')"),"2021")
            ->where(DB::raw("DATE_FORMAT(orders.created_at, '%m')"),$key)
            ->get();

            $count = 0;
            $total = 0;
            foreach($temp as $k => $v) {
                $count++;
                $total += $v->payment_amount;
            }
            $ordersByMonth[] = $count;
            $profitByMonth[] = $total;
        };

        $data = [
            "orders" => $orders,
            "years" => $years,
            "months" => $months,
            "ordersByYear" => $ordersByYear,
            "ordersByMonth" => $ordersByMonth,
            "profitByYear" => $profitByYear,
            "profitByMonth" => $profitByMonth
        ];
        return view("orders.index", $data);

    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_slug)
    {
        $user = DB::table("users")
                ->where("slug", $user_slug)
                ->first();

        $dishes = Dish::where('user_id', $user->id)->get();

        $data = [
            'dishes' => $dishes,
            'restaurant'=> $user->name,
        ];

        return view ('orders.create', $data);        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // spostato nella rotta di checkout
        // $request->validate([ 
        //     'delivery_address' => 'required|max:255',
        //     'customer_mail' => 'required|email:rfc,dns'
        // ]);
      
        // $data = $request->all();
        // $newOrder = new Order();
        // $newOrder->fill($data);

        // // temp
        // $newOrder["payment_amount"] = 10;
        // $newOrder["payment_status"] = true;

        // $newOrder->save();

        // $dishes = collect($request->input('dishes', [])) //colleziona i dati nell'input e li mappa con la...
        // ->filter(function($dish){
        //     return !is_Null($dish);
        // })
        // ->map(function($dish) {   
        //     return ['quantity' => $dish];  //...terza colonna chiamata nel model Order
        // });
        // //dd($dishes);
        // $newOrder->dishes()->sync($dishes);
        // return redirect()->route('welcome');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        // $order = Order::findOrFail($id);
        $data = [
            'order' => $order
        ];

        return view("orders.show", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
