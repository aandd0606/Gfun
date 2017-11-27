@extends('bs3')

@section('content')
    <h1>管理案件資料</h1>
<div class="row">
    @if(request()->segment(3)=='edit')
        {!! Form::model($case, ['route' => ['case.update',$case->id]]) !!}
    @else
        {!! Form::open(['url' => 'case']) !!}
    @endif


    <div class="col-md-3">
        <div class="form-group">
            {{Form::label('title', '抬頭')}}
            {{Form::text('title',null,['class' => 'form-control'])}}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{Form::label('number', '統一編號')}}
            {{Form::text('number',null,['class' => 'form-control'])}}
        </div>
    </div>
    <div class="col-md-3">

        <div class="form-group">
            {{Form::label('phone', '電話')}}
            {{Form::text('phone',null,['class' => 'form-control'])}}
        </div>
    </div>
    <div class="col-md-3">

        <div class="form-group">
            {{Form::label('fax', '傳真')}}
            {{Form::text('fax',null,['class' => 'form-control'])}}
        </div>
    </div>
    <div class="col-md-10">
        <div class="form-group">
            {{Form::label('address', '地址')}}
            {{Form::text('address',null,['class' => 'form-control'])}}
        </div>
    </div>
    <div class="col-md-2">

    <div class="form-group">
        @if(request()->segment(3)=='edit')
            {{Form::submit('修改顧客單位',['class'=>'btn btn-success'])}}
        @else
            {{Form::submit('新增顧客單位',['class'=>'btn btn-success'])}}
        @endif

    </div>
    {{csrf_field()}}
        @if(request()->segment(3)=='edit')
        {{ Form::hidden('_method',"PUT") }}
        @endif
    {!! Form::close() !!}
    </div>
</div>


<div class="row">
    @if($cases)
        <table class="table ">
            <tr><th>抬頭</th><th>統編</th><th>地址</th><th>電話</th><th>傳真</th><th>功能鍵</th></tr>
            @foreach ($cases as $case)
                <tr>
                    <td>{{ $case->title }}</td>
                    <td>{{ $case->number }}</td>
                    <td>{{ $case->address }}</td>
                    <td>{{ $case->phone }}</td>
                    <td>{{ $case->fax }}</td>
                    <td>
                        <a href="{{ url("case/{$case->id}/edit") }}"
                            class="btn btn-primary">修改</a>
                        {!! Form::open(['method' => 'DELETE', 'route' => ['case.destroy',$case->id],'onsubmit' => 'return confirm("確定要刪除嗎？")']) !!}
                        {{ Form::hidden('id', $case->id) }}
                        {{ Form::submit('刪除', ['class' => 'btn btn-danger']) }}
                        {{ Form::close() }}
                    </td>
                </tr>
            @endforeach
        </table>
    @endif

</div>
@endsection
