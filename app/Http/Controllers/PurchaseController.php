<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Order;
use Inertia\Inertia;
use Illuminate\Support\Facades\{DB, Log};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Redirect;

use function PHPSTORM_META\type;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function showPurchaseEditor($custid, $custname){
        $customer_id = 0;
        if($custid!==null){
            $customer_id = $custid;
            $count__ = Item::select('*')->where('customer_id', $customer_id)->get();
           
            if(count($count__)==0){
                $customer_id = 0;
            }
        }
        $customers = Customer::select('id', 'name', 'nickname', 'birthday')->get();
        $items = Item::select('id', 'name', 'type', 'loan_amount', 'property_value', 
        'down_payment', 'price','customer_id','user_id')
            ->where('is_selling', true)
            ->where('customer_id', $customer_id)//!! 0 za prototype items
            ->get();

        return Inertia::render('Purchases/Create', [
            'customers' => $customers,
            'items' => $items,
        ]);
     }
 
        public function index(Request $request)
        {
            $customer_name = $request->query('search');
            $advisers_filter = $request->query('advisersFilter');

            //dd($advisers_filter);

            if($customer_name !== null){

                $orders = Order::groupBy("id")->orderBy('created_at', 'DESC')
                ->selectRaw('id, customer_id, customer_name, sum(subtotal) as total, status, created_at, 
                adviser_id, adviser_name');

                if($advisers_filter=='1'){
                    $orders = $orders->where('adviser_id', Auth::id());
                }

                $orders = $orders->where('customer_name', 'LIKE', "%{$customer_name}%")
                ->paginate(50);

            }else{
                $orders = Order::groupBy("id")->orderBy('created_at', 'DESC')
                ->selectRaw('id, customer_id, customer_name, sum(subtotal) as total, status, created_at, 
                adviser_id, adviser_name');

                if($advisers_filter=='1'){
                    $orders = $orders->where('adviser_id', Auth::id());
                }

                $orders = $orders->paginate(50);
            }

            return Inertia::render('Purchases/Index', [
                'orders' => $orders
            ]);
        }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $cid = $request->get('cid');
        return $this->showPurchaseEditor($cid,null);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseRequest $request)
    {
        $addMessage = '';
        DB::beginTransaction();
        try {
            //dd( $request->items);

            $itemNewRecords = [];

            $count__ = Item::select('*')->where('customer_id', $request->customer_id)->get();
            //dd($count__);
            
            if(count($count__)>0){
                foreach ($request->items as $item) {
                    //dd("a user=".$item['user_id']."?".Auth::id()."=".($item['user_id'] == Auth::id())." item=".$item['id']);
                    if($item['user_id'] == Auth::id()){
                        Item::findOrFail($item['id'])->update([
                            'customer_id' => $request->customer_id,
                            'user_id' => Auth::id(),
                            'status' => $request->status,

                            'name' => $item['type'].' loan - c_id:'.$request->customer_id,
                            'type' => $item['type'],
                            'loan_amount' => $item['loan_amount'],
                            'property_value' => $item['property_value'],
                            'down_payment' => $item['down_payment'],
                            'memo' => '',
                            'price' => $item['price'],
                        ]);
                    }
                    else{
                        $addMessage = 'You can not do entries for other advisers.';
                        throw ValidationException::withMessages([
                            'You can not do entries for other advisers.',
                        ]);
                    }
                    DB::commit();
                }
            }
            else{
                foreach ($request->items as $item) {
                    //dd(" b user=".$item['user_id']."?".Auth::id()."=".($item['user_id'] == Auth::id()). " item=".$item['id']);
                    if($item['user_id'] == Auth::id()){
                        $itemNewRecords[] = Item::create([
                            'customer_id' => $request->customer_id,
                            'user_id' => Auth::id(),
                            'status' => $request->status,

                            'name' => $item['type'].' loan - c_id:'.$request->customer_id,
                            'type' => $item['type'],
                            'loan_amount' => $item['loan_amount'],
                            'property_value' => $item['property_value'],
                            'down_payment' => $item['down_payment'],
                            'memo' => '',
                            'price' => $item['price'],
                        ]);
                    }
                    else{
                        $addMessage = 'You can not do entries for other advisers.';
                        throw ValidationException::withMessages([
                            'You can not do entries for other advisers.',
                        ]);
                    }
                    DB::commit();
                }

                $purchase = Purchase::create([
                    'customer_id' => $request->customer_id,
                    'user_id' => Auth::id(),
                    'status' => $request->status,
                ]);

                foreach ($itemNewRecords as $item) {
                    $purchase->items()->attach(
                        $purchase->id,
                        [
                            'item_id' => $item->id,
                            'quantity' => 1
                        ]
                    );
                }
                DB::commit();
            }
        } catch (\Exception $e) {
            /*return to_route('purchases.create')->with([
                'message' => 'DB error!',
                'status' => 'error'
            ]);*/
            throw ValidationException::withMessages([
                'message' => 'DB error! '.$addMessage
            ]);
            Log::info($e);
            Log::alert("Purchase store error");
            DB::rollBack();
        }

        throw ValidationException::withMessages([
            'message' => 'Success!',
        ]);
        //return to_route('purchases.create');
        //return Redirect::to('/purchases/create?cid='.$request->customer_id.'&cname='.$request->customer_name);

    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        //Subtotal
        /*$items = Order::where('id', $purchase->id)->get();

        $order = Order::groupBy('id')->where('id', $purchase->id)->selectRaw('id, customer_name, sum(subtotal) as total, status, created_at')->get();

        return Inertia::render('Purchases/Show', [
            'items' => $items,
            'order' => $order
        ]);*/
        //dd($purchase->customer_name);
        //return $this->showPurchaseEditor($purchase->customer_id,$purchase->customer_name);
        return Redirect::to('/purchases/create?cid='.$purchase->customer_id.'&cname='.$purchase->customer_name);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        $purchase = Purchase::find($purchase->id);
        $allItems = Item::select('id', 'name', 'price')->get();
        $items = [];

        foreach ($allItems as $allItem) {
            $quantity = 0;
            foreach ($purchase->items as $item) {
                if ($allItem->id === $item->id) {
                    $quantity = $item->pivot->quantity;
                    array_push($items, [
                        'id' => $allItem->id,
                        'name' => $allItem->name,
                        'price' => $allItem->price,
                        'quantity' => $quantity
                    ]);
                }
            }
        }

        $order = Order::groupBy('id')->where('id', $purchase->id)->selectRaw('id, customer_name, customer_id, status, created_at')->get();

        return Inertia::render('Purchases/Edit', [
            'items' => $items,
            'order' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        $purchase->status = $request->status;
        $purchase->save();

        $items = [];
        foreach ($request->items as $item) {
            $items = $items + [
                $item['id'] => ['quantity' => $item['quantity']]
            ];
        }
        $purchase->items()->sync($items);
        return to_route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
