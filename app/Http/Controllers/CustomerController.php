<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Purchase;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $customers = Customer::searchCustomers($search)->select(
            'id', 'first_name' , 'last_name' , 'email', 'tel', 'has_cash_loan', 'has_home_loan')->paginate(50);
    Log::info($search);
        /*dd($search);
        dd($customers);*/
        return Inertia::render('Customers/Index', [
            'customers' => $customers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Customers/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        Customer::create([
            'name' => $request->name,
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'tel' => $request->tel,
            'email' => $request->email,
            'postcode' => $request->postcode,
            'address' => $request->address,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'memo' => $request->memo,
            'has_cash_loan' => $request->hasCashLoan,
            'has_home_loan' => $request->hasHomeLoan,
        ]);

        return to_route('customers.index')->with([
            'message' => 'Success. cust. route',
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {

        $items = Item::select('id', 'name', 'type', 'loan_amount', 'property_value', 'down_payment', 'price')->where('is_selling', true)->get();
        $purchases = Purchase::select()->where([
            ['customer_id', '=',$customer->id],
            ['status', '=', 1],
        ])->get();

  
 
        /*$orders = Order::groupBy("id")->orderBy('created_at', 'DESC')->selectRaw('id, customer_name, sum(subtotal) as total, status, created_at')
        ->where('customer_name', 'LIKE', "%{$customer_name}%")->paginate(50);*/


        return Inertia::render('Customers/Edit', [
            'customer' => $customer,
            'items' => $items,
            'purchases' => $purchases
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->name = $request->name;
        $customer->first_name = $request->firstName;
        $customer->last_name = $request->lastName;
        $customer->email = $request->email;
        $customer->tel = $request->tel;
        $customer->gender = $request->gender;
        $customer->memo = $request->memo;
        $customer->has_cash_loan = $request->hasCashLoan;
        $customer->has_home_loan = $request->hasHomeLoan;

        $customer->save();

        return to_route('customers.index')
        ->with([
            'message' => 'Update done',
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {

        try{
            $customer->delete();
        }catch(\Illuminate\Database\QueryException $e){

            return to_route('customers.index')
            ->with([
                'message' => 'Foreign key constraint violation!',
                'status' => 'danger'
            ]);
        }

        return to_route('customers.index')
        ->with([
            'message' => 'Deletetion done',
            'status' => 'danger'
        ]);
    }
}
