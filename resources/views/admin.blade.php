@extends('bs3')

@section('content')
<div class="row">
    <h1>管理員頁面</h1>
    <h2>細項搜尋</h2>
    {!! Form::open(['url' => 'admin']) !!}
    <div class="col-md-2">
        <div class="form-group">
        {{Form::label('customer_id', '選擇顧客')}}
        {{Form::select('customer_id',$customers,null,['class' => 'form-control'])}}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {{Form::label('product', '輸入關鍵字')}}
            {{Form::text('product',null,['class' => 'form-control'])}}
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
    {{Form::label('', '')}}
    {{Form::submit('搜尋',['class'=>'btn btn-success'])}}
        </div>
    </div>
    {!! Form::close() !!}
</div>
    @if($searchProducts)
        <div class="row">
            <table class="table table-responsive table-bordered">
                <tr>
                    <th>細項</th>
                    <th>收據</th>
                    <th>案子</th>
                    <th>顧客</th>
                    <th>單價</th>
                    <th>數量</th>
                    <th>小計</th>
                    <th>廠商</th>
                    <th>成本</th>
                    <th>出貨日期</th>
                    <th>貨款日期</th>
                </tr>
                @foreach($searchProducts as $searchProduct)
                    <tr>
                        <td><a href="{{ url("product/receipt/{$searchProduct->receipt_id}/edit/{$searchProduct->id}") }}" target="_blank">{{ $searchProduct->product }}</a></td>
                        <td><a href="{{ url("product/receipt/{$searchProduct->receipt_id}") }}" target="_blank">{{ $searchProduct->work }}</a></td>
                        <td><a href="{{url("project/{$searchProduct->project_id}")  }}" target="_blank">{{ $searchProduct->name }}</a></td>
                        <td><a href="{{url("admin/customer/{$searchProduct->customer_id}")  }}" target="_blank">{{ $searchProduct->title }}</a></td>
                        <td>{{ $searchProduct->price }}</td>
                        <td>{{ $searchProduct->amount }}</td>
                        <td>{{ $searchProduct->subtotal }}</td>
                        <td>{{ $companies[$searchProduct->company_id] }}</td>
                        <td>{{ $searchProduct->cost }}</td>
                        <td>{{ $searchProduct->shipdate }}</td>
                        <td>{{ $searchProduct->paymentdate }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif
@endsection
