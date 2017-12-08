<?php

namespace App\Http\Controllers;

use App\Company;
use App\Customer;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    protected $customerArr=[];
    protected $companyArr=[];

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::check()){
                if(Auth::user()->power == "admin"){
                    return $next($request);//通過中介層
                }else{
                    //有登入沒有權限
                    return response("沒有權限",202);
                }
            }else{
                //根本沒登入
                return response("沒有登入",202);
            }
        });

        //取得所有顧客資料要產生表單陣列
        $customers = Customer::get();
        $this->customerArr[0]="";
        foreach ($customers as $customer){
            $this->customerArr[$customer->id]=$customer->title;
        }
        //取得所有協作廠商資料要產生表格陣列
        $companies = Company::get();
        foreach ($companies as $company){
            $this->companyArr[$company->id]=$company->title;
        }
    }

    //
    public function index(){
        $searchProducts =[];

        return view('admin')
                ->with('customers',$this->customerArr)
                ->with('companies',$this->companyArr)
                ->with('searchProducts',$searchProducts);
    }

    public function searchList(Request $request){
        //開始搜尋

        $searchProducts = $this->searchProduct($request->customer_id,$request->product);
        return view('admin')
            ->with('customers',$this->customerArr)
            ->with('companies',$this->companyArr)
            ->with('searchProducts',$searchProducts);
    }

    protected function searchProduct($customer_id="",$product="")
    {
        if (empty($customer_id) AND empty($product)) {
            $customerProduct=[];
        }
        if (empty($customer_id)) {
            //只有關鍵字沒有學校
            $customerProduct = DB::table('customers')
                ->leftJoin('projects', 'customers.id', '=', 'projects.customer_id')
                ->leftJoin('receipts', 'projects.id', '=', 'receipts.project_id')
                ->leftJoin('products','receipts.id','=','products.receipt_id')
                ->where('products.product','like','%'.$product.'%')
                ->get();        } else {
//            有學校沒有關鍵字
            if (empty($product)) {
                $customerProduct = DB::table('customers')
                    ->leftJoin('projects', 'customers.id', '=', 'projects.customer_id')
                    ->leftJoin('receipts', 'projects.id', '=', 'receipts.project_id')
                    ->leftJoin('products','receipts.id','=','products.receipt_id')
                    ->where('customers.id',$customer_id)
                    ->get();
            } else {
                $customerProduct = DB::table('customers')
                    ->leftJoin('projects', 'customers.id', '=', 'projects.customer_id')
                    ->leftJoin('receipts', 'projects.id', '=', 'receipts.project_id')
                    ->leftJoin('products','receipts.id','=','products.receipt_id')
                    ->where('customers.id',$customer_id)
                    ->where('products.product','like','%'.$product.'%')
                    ->get();
            }
        }
        return $customerProduct;
//        dd($customerProduct);
    }
}
