<?php

namespace App\Http\Controllers;

use App\Company;
use App\Income;
use App\Product;
use App\Project;
use App\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $cols =[
        'receipt_id',
        'product',
        'price',
        'amount',
        'subtotal',
        'company_id',
        'cost',
        'detail',
        'user_id',
        'closing',
        'shipdate',
        'paymentdate',
    ];

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
        //
    }

    public function create($receipt_id,$id="")
    {
        $incomes = Income::where('receipt_id',$receipt_id)->get();
        $receipt = Receipt::findOrFail($receipt_id);
        $project = Project::findOrFail($receipt->project_id);
        $products = Product::where('receipt_id',$receipt_id)->get();
        if(!empty($id)){
            $product = Product::findOrFail($id);
//            $receipt =
            $company = Company::findOrFail($product->company_id);
        }else{
            $product =[];
        }

        $companies =Company::all();
        $companiesArr[0]="";
        foreach ($companies as $company){
            $companiesArr[$company->id] =$company->title;
        }

        //算出收據總金額
        $receiptTotal = Product::where('receipt_id',$receipt_id)->sum('subtotal');
        //算出廠商成本
        $costTotal = Product::where('receipt_id',$receipt_id)->sum('cost');
        //算出收入總金額
        $incomeTotal = Income::where('receipt_id',$receipt_id)->sum('income');

        return view('product')
                ->with('costTotal',$costTotal)
                ->with('receiptTotal',$receiptTotal)
                ->with('incomeTotal',$incomeTotal)
                ->with('products',$products)
                ->with('product',$product)
                ->with('companies',$companiesArr)
                ->with('company',$company)
                ->with('receipt',$receipt)
                ->with('incomes',$incomes)
                ->with('project',$project);
    }

    public function store(Request $request)
    {
        //
//        dd($request->all());
        $product = Product::create($request->only($this->cols));
        return redirect()->route(
            'product.create',
            ['id' => $request->receipt_id]);
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

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
        $product = Product::findOrFail($id);
        foreach($this->cols as $col){
            $product->$col = $request->$col;
        }
//        dd($product);

        $product->save();
        return redirect()->route("product.create",['receipt_id'=>$request->receipt_id]);

    }

    public function destroy($id)
    {
        //
        $product = Product::findOrFail($id);
        Product::destroy($id);
        return redirect()->route(
            'product.create',
            ['id' => $product->receipt_id]);
    }

    /**
     * @param $receipt_id
     */
    public function receiptword($receipt_id){
        Storage::delete('recipet.docx');
        $receipt =Receipt::findOrFail($receipt_id);
        $project = Project::findOrFail($receipt->project_id);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();

        $table = $section->addTable();
        $table->addRow();
        $table->addCell(1500)->addText("",['name' => 'Tahoma', 'size' => 20]);
        $table->addCell(5000)->addText("免用統一發票收據",['name' => 'Tahoma', 'size' => 24]);
        $table->addCell(3000)->addText("統一編號：{$receipt->number}",['name' => 'Tahoma', 'size' => 14]);

        $section->addText("");
        $section->addText("");


        $table = $section->addTable();
        $table->addRow();
        $table->addCell(6000)->addText("{$receipt->title}  台照",['name' => 'Tahoma', 'size' => 18]);
        $table->addCell(1)->addText("",['name' => 'Tahoma', 'size' => 20]);
        $table->addCell(4000)->addText("中華民國：".dateToROC($receipt->outdate),['name' => 'Tahoma', 'size' => 13]);

        $section->addText("");

        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 120, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $fancyTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => '66BBFF');
        $fancyTableCellStyle = array('valign' => 'center');
        $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $fancyTableFontStyle = array('bold' => true,'size'=>14);

        //設定表格合併rowspan
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);

        //標頭表格
        $table = $section->addTable($fancyTableStyleName);
        $table->addRow();
        $table->addCell(2500,$fancyTableCellStyle)->addText('品名', $fancyTableFontStyle);
        $table->addCell(1200,$fancyTableCellStyle)->addText('單價', $fancyTableFontStyle);
        $table->addCell(1000,$fancyTableCellStyle)->addText('數量', $fancyTableFontStyle);
        $table->addCell(1300,$fancyTableCellStyle)->addText('金額', $fancyTableFontStyle);
        $table->addCell(2700,$fancyTableCellStyle)->addText('備註', $fancyTableFontStyle);

        $products = Product::where('receipt_id',$receipt->id)->get();
        $totalMoney = Product::where('receipt_id',$receipt->id)->sum('subtotal');
        //細項表格
        $n=0;
        foreach ($products as $product){
            $n++;
            $table->addRow();
            $table->addCell(2500,$fancyTableCellStyle)->addText($product->product, $fancyTableFontStyle);
            $table->addCell(1200,$fancyTableCellStyle)->addText($product->price, $fancyTableFontStyle);
            $table->addCell(1000,$fancyTableCellStyle)->addText($product->amount, $fancyTableFontStyle);

            $table->addCell(1300,$fancyTableCellStyle)->addText($product->subtotal, $fancyTableFontStyle);
            if($n==1){
                $table->addCell(2700,$cellRowSpan)->addText('', $fancyTableFontStyle);
            }else{
                $table->addCell(2700,$cellRowContinue)->addText('', $fancyTableFontStyle);
            }

        }
        while ($n<8){
            $n++;
            $table->addRow();
            $table->addCell(2500,$fancyTableCellStyle)->addText('', $fancyTableFontStyle);
            $table->addCell(1500,$fancyTableCellStyle)->addText('', $fancyTableFontStyle);
            $table->addCell(1200,$fancyTableCellStyle)->addText('', $fancyTableFontStyle);
            $table->addCell(1500,$fancyTableCellStyle)->addText('', $fancyTableFontStyle);
            $table->addCell(2000,$cellRowContinue)->addText('', $fancyTableFontStyle);

        }
        //表格結尾
        $table = $section->addTable($fancyTableStyleName);

        $table->addRow();
        $table->addCell(4800,['bold' => true,'size'=>14])->addText("合計", ['bold' => true,'size'=>14],array('align' => 'right'));
        $table->addCell(1200,$fancyTableCellStyle)->addText($totalMoney, $fancyTableFontStyle);
        $table->addCell(1000,$cellRowSpan)->addText('銀貨兩訖', $fancyTableFontStyle);
        $table->addCell(1700,$cellRowSpan)->addText('', $fancyTableFontStyle);
        $table = $section->addTable($fancyTableStyleName);

        $table->addRow();
        $table->addCell(6000,$fancyTableCellStyle)->addText("合計新台幣  ".num2str($totalMoney), $fancyTableFontStyle);
        $table->addCell(1000,$cellRowContinue)->addText('', $fancyTableFontStyle);
        $table->addCell(1700,$cellRowContinue)->addText('', $fancyTableFontStyle);

        $fontStyle = new \PhpOffice\PhpWord\Style\Font();
        $fontStyle->setBold(true);
        $fontStyle->setName('Tahoma');
        $fontStyle->setSize(10);
        $myTextElement = $section->addText('聚豐企業社。  電話：XXXXXXXX   傳真：XXXXXXX   地址：XXXXXXXXXXXXXXXXXXXXXXXX');
        $myTextElement->setFontStyle($fontStyle);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('recipet.docx');
        return response()->download('recipet.docx',$receipt->title."-".$project->name."-".$receipt->work.$receipt->total."收據.docx");

    }
    public function orderword($receipt_id){
        Storage::delete('recipet.docx');
        $receipt =Receipt::findOrFail($receipt_id);
        $project = Project::findOrFail($receipt->project_id);
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();

        $table = $section->addTable();
        $table->addRow();
        $table->addCell(3000)->addText("",['name' => 'Tahoma', 'size' => 20]);
        $table->addCell(3000)->addText("估價單",['name' => 'Tahoma', 'size' => 28]);
        $table->addCell(3000)->addText("統一編號：{$receipt->number}",['name' => 'Tahoma', 'size' => 14]);

        $section->addText("");
        $section->addText("");


        $table = $section->addTable();
        $table->addRow();
        $table->addCell(6000)->addText("{$receipt->title}  台照",['name' => 'Tahoma', 'size' => 18]);
        $table->addCell(100)->addText("",['name' => 'Tahoma', 'size' => 20]);
        $table->addCell(3900)->addText("中華民國：".dateToROC($receipt->outdate),['name' => 'Tahoma', 'size' => 13]);

        $section->addText("");

        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 120, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $fancyTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => '66BBFF');
        $fancyTableCellStyle = array('valign' => 'center');
        $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $fancyTableFontStyle = array('bold' => true,'size'=>14);

        //設定表格合併rowspan
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);

        //標頭表格
        $table = $section->addTable($fancyTableStyleName);
        $table->addRow();
        $table->addCell(4000,$fancyTableCellStyle)->addText('品名', $fancyTableFontStyle);
        $table->addCell(1500,$fancyTableCellStyle)->addText('單價', $fancyTableFontStyle);
        $table->addCell(1500,$fancyTableCellStyle)->addText('數量', $fancyTableFontStyle);
        $table->addCell(3000,$fancyTableCellStyle)->addText('金額', $fancyTableFontStyle);

        $products = Product::where('receipt_id',$receipt->id)->get();
        $totalMoney = Product::where('receipt_id',$receipt->id)->sum('subtotal');
        //細項表格
        $n=0;
        foreach ($products as $product){
            $n++;
            $table->addRow();
            $table->addCell(4000,$fancyTableCellStyle)->addText($product->product, $fancyTableFontStyle);
            $table->addCell(1500,$fancyTableCellStyle)->addText($product->price, $fancyTableFontStyle);
            $table->addCell(1500,$fancyTableCellStyle)->addText($product->amount, $fancyTableFontStyle);

            $table->addCell(3000,$fancyTableCellStyle)->addText($product->subtotal, $fancyTableFontStyle);


        }
        while ($n<8){
            $n++;
            $table->addRow();
            $table->addCell(4000,$fancyTableCellStyle)->addText('', $fancyTableFontStyle);
            $table->addCell(1500,$fancyTableCellStyle)->addText('', $fancyTableFontStyle);
            $table->addCell(1500,$fancyTableCellStyle)->addText('', $fancyTableFontStyle);
            $table->addCell(3000,$fancyTableCellStyle)->addText('', $fancyTableFontStyle);

        }
        //表格結尾
        $table = $section->addTable($fancyTableStyleName);

        $table->addRow();
        $table->addCell(7000,['bold' => true,'size'=>14])->addText("合計", ['bold' => true,'size'=>14],array('align' => 'right'));
        $table->addCell(3000,$fancyTableCellStyle)->addText($totalMoney, $fancyTableFontStyle);
        $table = $section->addTable($fancyTableStyleName);

        $table->addRow();
        $table->addCell(10000,$fancyTableCellStyle)->addText("合計新台幣  ".num2str($totalMoney), $fancyTableFontStyle);

        $fontStyle = new \PhpOffice\PhpWord\Style\Font();
        $fontStyle->setBold(true);
        $fontStyle->setName('Tahoma');
        $fontStyle->setSize(10);
        $myTextElement = $section->addText('聚豐企業社：   電話：08-7383017   傳真：08-7383017   地址：屏東市大連里興豐路74號');
        $myTextElement->setFontStyle($fontStyle);
        $myTextElement = $section->addText('匯款帳號資訊：  戶名：聚豐企業社曾琪雯    銀行：玉山銀行-屏東分行    帳號：0934-940-157101');
        $myTextElement->setFontStyle($fontStyle);

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('order.docx');
        return response()->download('order.docx',$receipt->title."-".$project->name."-".$receipt->work.$receipt->total."估價單.docx");

    }
}
