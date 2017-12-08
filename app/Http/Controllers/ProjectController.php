<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Income;
use App\Product;
use App\Project;
use App\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    protected  $cols = ['customer_id','name','person','date'];

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

    }


    public function index()
    {

        $projects = Project::all();
        //案件資料關聯顧客
        $projects = $this->getProjectLeftJoinCustomer();

        $customers = array();
        //整理顧客資料
        foreach ( Customer::all() as $customer){
            $customers[$customer->id]=$customer->title.$customer->number;
        }

        //算出該案子的所有收據總價錢陣列
        foreach($projects as $project){
            $projectReceiptsTotal[$project->id]=$this->projectReceiptsTotal($project->id);
            $projectCostsTotal[$project->id]=$this->projectCostsTotal($project->id);
            $projectIncomesTotal[$project->id]=$this->projectIncomesTotal($project->id);
        }

        //算出收據總金額
//        $receiptTotal = Product::where('receipt_id',$receipt_id)->sum('subtotal');
        //算出廠商成本
//        $costTotal = Product::where('receipt_id',$receipt_id)->sum('cost');
        //算出收入總金額
//        $incomeTotal = Income::where('receipt_id',$receipt_id)->sum('income');

        return view('project',["projects" => $projects])
                ->with("projectReceiptsTotal",$projectReceiptsTotal)
                ->with("projectCostsTotal",$projectCostsTotal)
                ->with("projectIncomesTotal",$projectIncomesTotal)
                ->with("customers",$customers);
    }

        protected function projectReceiptsTotal($project_id=""){
            $total=0;
            $receipts = Receipt::where('project_id',$project_id)->get();
            foreach($receipts as $receipt){
                $total += Product::where('receipt_id',$receipt->id)->sum('subtotal');
            }
            return $total;
        }
    protected function projectCostsTotal($project_id=""){
        $total=0;
        $receipts = Receipt::where('project_id',$project_id)->get();
        foreach($receipts as $receipt){
            $total += Product::where('receipt_id',$receipt->id)->sum('cost');
        }
        return $total;
    }
    protected function projectIncomesTotal($project_id=""){
        $total=0;
        $receipts = Receipt::where('project_id',$project_id)->get();
        foreach($receipts as $receipt){
            $total += Income::where('receipt_id',$receipt->id)->sum('income');
        }
        return $total;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $project = Project::create($request->only($this->cols));
        return redirect()->route('project.index',$project);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$receipt_id="")
    {
//        dd($receipt_id);
        //找出案件資料
        $projects = $this->getProjectLeftJoinCustomer($id);
        //找出收據資料
        $receipts = Receipt::where('project_id',$id)->get();
        if(!empty($receipt_id)){
            $receipt = Receipt::where('id',$receipt_id)->first();
//            dd($receipt);
            return view("projectshow",["projects" => $projects])
                    ->with("receipts",$receipts)
                    ->with('receipt',$receipt);
        }else{
            return view("projectshow",["projects" => $projects])
                ->with("receipts",$receipts);
        }



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $customer = Customer::findOrFail($project->customer_id);
        //整理顧客資料(給表單用)
        foreach ( Customer::all() as $customer){
            $customers[$customer->id]=$customer->title.$customer->number;
        }
        //案件資料關聯顧客
        $projects = $this->getProjectLeftJoinCustomer();
        return view("project",[
                        "project" => $project,
                        "projects" => $projects,
                        "customer" => $customer,
                        "customers" => $customers,
                    ]);
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
        $project = Project::findOrFail($id);
        foreach($this->cols as $col){
            $project->$col = $request->$col;
        }
        $project->save();
        return redirect()->route('project.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Project::destroy($id);
        return redirect()->route('project.index');
    }

    protected function getProjectLeftJoinCustomer($id=""){
        if(empty($id)){
            $projects = DB::table('projects')
                ->leftJoin('customers',"customers.id","=","projects.customer_id")
                ->select('projects.*', 'customers.title', 'customers.number')
                ->orderByDesc('id')
                ->get();
            return $projects;
        }else{
            $project = DB::table('projects')
                ->leftJoin('customers',"customers.id","=","projects.customer_id")
                ->select('projects.*', 'customers.title', 'customers.number')
                ->where('projects.id',$id)
                ->take(1)
                ->get();
            return $project;
        }

    }
}
