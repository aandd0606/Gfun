<?php
namespace App\Http\Controllers;
use App\Customer;
use Illuminate\Http\Request;
class CustomerController extends Controller
{
    protected $cols = ['title','number','address','phone','fax'];
    public function __construct()
    {
    }
    public function index()
    {
        $customers = Customer::all();
        return view("customer",['customers'=>$customers]);
    }
    public function store(Request $request)
    {
        Customer::create($request->only($this->cols));
        $customers = Customer::all();
        return view("customer",['customers'=>$customers]);
    }
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
    }
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $customers = Customer::all();
        return  view("customer",['customer'=>$customer])
                ->with('customers',$customers);
    }
     public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        foreach ($this->cols as $col){
            $customer->$col = $request->$col;
        }
        $customer->save();
        return redirect()->route('customer.index');
    }
    public function destroy($id)
    {
        Customer::destroy($id);
        return redirect()->route('customer.index');
    }
}