@extends('bs3')

@section('content')
    <h1>管理案件資料</h1>
<div class="row">
    @if($projects)
        @foreach($projects as $project)
            <table class="table ">
                <tr><th>顧客</th><th>名稱</th><th>負責人</th><th>日期</th><th>預算金額</th><th>功能鍵</th></tr>
                <tr>
                    <td>{{ $project->title }}({{ $project->number }})</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->person }}</td>
                    <td>{{ $project->date }}</td>
                    <td>{{ $project->prepare }}</td>
                    <td></td>
                </tr>
            </table>
        @endforeach
    @endif

</div>
    <div class="row">
        <div class="col-md-offset-1 col-md-11">
            <table class="table">
                <tr><th>建立收據
                        @if( !request()->segment(3) == "edit" )
                            <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                開啟表單
                            </a>
                        @endif

                        @if( !request()->segment(3) == "edit" )
                            <div class="collapse" id="collapseExample">
                        @endif
                            @if(request()->segment(3) == "edit")
                                    {{--{!! dd($receipt) !!}--}}
                                {!! Form::model($receipt, ['route' => ['receipt.update', $receipt->id]]) !!}
                                {{ Form::hidden('_method',"PUT") }}
                            @else
                                {!! Form::open(['url' => 'receipt']) !!}
                            @endif


                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('work', '收據主旨')}}
                                        {{Form::text('work',null,['class' => 'form-control'])}}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{Form::label('title', '收據抬頭')}}
                                        @if( !request()->segment(3) == "edit" )
                                        {{Form::text('title',$project->title,['class' => 'form-control'])}}
                                        @else
                                            {{Form::text('title',$receipt->title,['class' => 'form-control'])}}
                                        @endif

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{Form::label('number', '收據統編')}}
                                        @if( !request()->segment(3) == "edit" )
                                        {{Form::text('number',$project->number,['class' => 'form-control'])}}
                                        @else
                                            {{Form::text('number',$receipt->number,['class' => 'form-control'])}}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{Form::label('outdate', '開出日期')}}
                                        {{Form::date('outdate',null,['class' => 'form-control'])}}
                                    </div>
                                </div>
                                {{--<div class="col-md-3">--}}
                                    {{--<div class="form-group">--}}
                                        {{--{{Form::label('total', '收據總金額')}}--}}
                                        {{--{{Form::text('total',null,['class' => 'form-control'])}}--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{csrf_field()}}
                                {{ Form::hidden('project_id',request()->segment(2)) }}

                                <div class="col-md-3">
                                    <div class="form-group">
                                        @if( request()->segment(3) == "edit" )
                                            {{Form::submit('修改收據',['class'=>'btn btn-success'])}}
                                        @else
                                            {{Form::submit('新增收據',['class'=>'btn btn-success'])}}
                                        @endif
                                    </div>
                                </div>
                                {{csrf_field()}}
                                {{ Form::hidden('project_id',request()->segment(2)) }}

                                {!! Form::close() !!}
                        @if( !request()->segment(3) == "edit" )
                            </div>
                        @endif

                    </th></tr>

                @if($receipts)
                    <table class="table">
                    <tr><th>收據主旨</th><th>收據抬頭</th><th>收據統編</th><th>開出日期</th><th>收據總金額</th><th>管理</th></tr>
                    <tr>
                        @foreach($receipts as $receipt)
                        <td class="warning">{{ $receipt->work }}</td>
                        <td class="warning">{{ $receipt->title }}</td>
                        <td class="warning">{{ $receipt->number }}</td>
                        <td class="warning">{{ $receipt->outdate }}</td>
                        <td class="warning">{{ $receipt->total }}</td>
                        <td class="warning">
                            {!! Form::open(['method' => 'DELETE', 'route' => ['receipt.destroy',$receipt->id],'onsubmit' => 'return confirm("確定要刪除嗎？")']) !!}
                            {{ Form::hidden('id', $receipt->id) }}
                            <a class="btn btn-info" href="{{ url("/product/receipt/{$receipt->id}")  }}" target="_blank">管理</a>
                            <a href="{{ url("project/{$project->id}/edit/$receipt->id") }}"
                               class="btn btn-primary">修改</a>
                            {{ Form::submit('刪除', ['class' => 'btn btn-danger']) }}
                            {{ Form::close() }}
                        </td>
                    </tr>
                        @endforeach
                    </table>
                @endif

            </table>
        </div>
    </div>
@endsection
