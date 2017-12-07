<?php

namespace App\Http\Controllers;

use App\Receipt;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    protected $cols = ['work','title','number','outdate','total','project_id'];
//    /**
//     * Display a listing of the resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function index()
//    {
//        //
//        return view('projectshow');
//    }

//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function create()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
//        dd($request->all());
        $receipt = Receipt::create($request->only($this->cols));
        return redirect()->route('project.show',['id' => $request->project_id]);
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
        $receipt = Receipt::findOrFail($id);
        foreach ($this->cols as $col) {
            $receipt->$col = $request->$col;
        }
        $receipt->save();
       return redirect()->route("project.show",$request->project_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $receipt = Receipt::findOrFail($id);
        Receipt::destroy($id);
        return redirect()->route('project.show',['id' => $receipt->project_id]);
    }
}
