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
        $projects = $this->getProjectLeftJoinCustomer();

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
        $project = Project::create($request->only($this->cols));
        return redirect()->route('project.index',$project);
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
        $projects = $this->getProjectLeftJoinCustomer($id);

//        dd($projects[0]);
//        $projects->toArray();
//        dd($projects);
        return view("projectshow",["projects" => $projects]);

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
