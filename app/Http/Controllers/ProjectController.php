<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    protected  $cols = ['customer_id','name','person','date','prepare'];

    public function index()
    {
        //
        $projects = Project::all();
        //案件資料關聯顧客
        $projects = DB::table('projects')
                        ->leftJoin('customers',"customers.id","=","projects.customer_id")
                        ->select('projects.*', 'customers.title', 'customers.number')
                        ->get();
//        dd($projects);
        $customers = array();
        //整理顧客資料
        foreach ( Customer::all() as $customer){
            $customers[$customer->id]=$customer->title.$customer->number;
        }

        return view('project',["projects" => $projects])
                ->with("customers",$customers);
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
//        dd($request);
        $project = Project::create($request->only($this->cols));
        dd($project);
        return redirect()->route('project',$project);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
