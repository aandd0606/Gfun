<?php
namespace App\Http\Controllers;
use App\Company;
use Illuminate\Http\Request;
class CompanyController extends Controller
{
    protected $cols = ['title','number','address','phone','fax'];
    public function __construct()
    {
    }
    public function index()
    {
        $companys = Company::all();
        return view("company",['companys'=>$companys]);
    }
    public function store(Request $request)
    {
        Company::create($request->only($this->cols));
        $companys = Company::all();
        return view("company",['companys'=>$companys]);
    }
    public function show($id)
    {
        $Company = Company::findOrFail($id);
    }
    public function edit($id)
    {
        $Company = Company::findOrFail($id);
        $companys = Company::all();
        return  view("company",['company'=>$Company])
                ->with('companys',$companys);
    }
     public function update(Request $request, $id)
    {
        $Company = Company::findOrFail($id);
        foreach ($this->cols as $col){
            $Company->$col = $request->$col;
        }
        $Company->save();
        return redirect()->route('company.index');
    }
    public function destroy($id)
    {
        Company::destroy($id);
        return redirect()->route('company.index');
    }
}