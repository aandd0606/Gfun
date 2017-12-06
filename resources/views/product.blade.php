@extends('bs3')

@section('content')
    <script>
        $(function(){
            $('#price').change(function(){
                var price = $(this).val();
                var amount = $('#amount').val();
                $('#subtotal').val( price*amount);
            });
            $('#amount').change(function(){
                var amount = $(this).val();
                var price = $('#price').val();
                $('#subtotal').val( price*amount);
            });
        });
    </script>
    <h1>收據工作細項管理
        @if( !request()->segment(4) == "edit" )
        <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
             開啟表單
        </a>
        @endif
        <a class="btn btn-info" href="{{ url("product/orderword/{$receipt->id}") }}">估價單</a>
        <a class="btn btn-warning" href="{{ url("product/receiptword/{$receipt->id}") }}">收據</a>
    </h1>
    <div class="row well">
        <p class="col-md-4">案子名稱：<a href="{{ url("project/{$project->id}") }}">{{ $project->name }}</a></p>
        <p class="col-md-4">案子負責人：{{ $project->person }}</p>
        <p class="col-md-4">工作項目：{{ $receipt->work }}</p>
        <p class="col-md-4">抬頭：<a href="{{ url("admin/customer/{$project->customer_id}") }}">{{ $receipt->title }}</a></p>
        <p class="col-md-4">統編：{{ $receipt->number }}</p>
        <p class="col-md-4">開出日期：{{ $receipt->outdate }}</p>
        <p class="col-md-4">收據金額：{{ $receiptTotal }}</p>
        <p class="col-md-4">廠商成本：{{ $costTotal }}</p>
        <p class="col-md-4">已收金額：</p>

    </div>
@if( !request()->segment(4) == "edit" )
<div class="collapse" id="collapseExample">
@endif

    <div class="row">
        @if(request()->segment(4)=='edit')
            {!! Form::model($product, ['route' => ['product.update',$product->id]]) !!}
        @else
            {!! Form::open(['url' => 'product']) !!}
        @endif


        <div class="col-md-3">
            <div class="form-group">
                {{Form::label('product', '品項')}}
                {{Form::text('product',null,['class' => 'form-control'])}}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {{Form::label('price', '單價')}}
                {{Form::text('price',null,['class' => 'form-control'])}}
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                {{Form::label('amount', '數量')}}
                {{Form::text('amount',null,['class' => 'form-control'])}}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {{Form::label('subtotal', '小計')}}
                {{Form::text('subtotal',null,['class' => 'form-control'])}}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {{Form::label('user_id', '負責工作人員')}}
                {{Form::select('user_id',['0'=>"",'1'=>'涂志宏','2'=>'曾琪雯'],null,['class' => 'form-control'])}}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {{Form::label('closing', '結案')}}
                {{Form::select('closing',['否'=>'否','是'=>'是'],null,['class' => 'form-control'])}}
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                {{Form::label('company_id', '協作廠商')}}
                {{Form::select('company_id',$companies,null,['class' => 'form-control'])}}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {{Form::label('cost', '成本')}}
                {{Form::text('cost',null,['class' => 'form-control'])}}
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {{Form::label('shipdate', '出貨日期')}}
                {{Form::date('shipdate',null,['class' => 'form-control'])}}
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {{Form::label('paymentdate', '貨款發出日期')}}
                {{Form::date('paymentdate',null,['class' => 'form-control'])}}
            </div>
        </div>



        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('detail', '製作細節')}}
                {{Form::text('detail',null,['class' => 'form-control'])}}
            </div>
        </div>

        <div class="col-md-1">
            <div class="form-group">
                @if(request()->segment(4)=='edit')
                    {{Form::label('', '')}}
                    {{Form::submit('修改案件',['class'=>'btn btn-success'])}}
                @else
                    {{Form::label('', '')}}
                    {{Form::submit('新增案件',['class'=>'btn btn-success'])}}
                @endif

            </div>
            {{csrf_field()}}
            {{ Form::hidden('receipt_id',$receipt->id)}}
                @if(request()->segment(4)=='edit')
                {{ Form::hidden('_method',"PUT") }}
                @endif
            {!! Form::close() !!}
        </div>
    </div>
@if( !request()->segment(4) == "edit" )
</div>
@endif
<div class="row">
    @if($products)
        <table class="table ">
            <tr><th>品項</th><th>單價</th><th>數量</th><th>小計</th><th>協作廠商</th><th>成本</th><th>細節</th><th>出貨日期</th><th>貨款日期</th><th>功能鍵</th></tr>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->product }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->amount }}</td>
                    <td>{{ $product->subtotal }}</td>
                    <td>{{ $company->title }}</td>
                    <td>{{ $product->cost }}</td>
                    <td>{{ $product->detail }}</td>
                    <td>{{ $product->shipdate }}</td>
                    <td>{{ $product->paymentdate }}</td>
                    <td>


                        {!! Form::open(['method' => 'DELETE', 'route' => ['product.destroy',$product->id],'onsubmit' => 'return confirm("確定要刪除嗎？")']) !!}
                        {{ Form::hidden('id', $product->id) }}
                        <a href="{{ url("product/receipt/{$product->receipt_id}/edit/{$product->id}") }}"
                           class="btn btn-primary">修改</a>
                        {{ Form::submit('刪除', ['class' => 'btn btn-danger']) }}
                        {{ Form::close() }}


                    </td>
                </tr>
            @endforeach
        </table>
    @endif
    <div class="row">
        <div class="col-md-3"><h2>收入金額管理</h2></div>
        <div class="col-md-3">
            @if(request()->segment(4)=='edit')
                {!! Form::model($income, ['route' => ['income.update',$income->id]]) !!}
            @else
                {!! Form::open(['url' => 'income']) !!}
            @endif
            <div class="form-group">
                {{Form::label('incomedate', '收入日期')}}
                {{Form::text('incomedate',null,['class' => 'form-control'])}}
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {{Form::label('income', '收入金額')}}
                {{Form::text('income',null,['class' => 'form-control'])}}
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {{Form::label('income', '收入金額')}}
                {{Form::text('income',null,['class' => 'form-control'])}}
            </div>
        </div>
        {!! Form::close() !!}
    </div>

</div>
@endsection
