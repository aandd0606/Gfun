@extends('bs3')

@section('content')
    <h1>管理案件資料</h1>
<div class="row">
    @if(request()->segment(3)=='edit')
        {!! Form::model($project, ['route' => ['project.update',$project->id]]) !!}
    @else
        {!! Form::open(['url' => 'project']) !!}
    @endif


    <div class="col-md-3">
        <div class="form-group">
            {{Form::label('customer_id', '選擇顧客')}}
            {{Form::select('customer_id',$customers,null,['class' => 'form-control'])}}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{Form::label('name', '案件名稱')}}
            {{Form::text('name',null,['class' => 'form-control'])}}
        </div>
    </div>
    <div class="col-md-3">

        <div class="form-group">
            {{Form::label('person', '負責人')}}
            {{Form::text('person',null,['class' => 'form-control'])}}
        </div>
    </div>
    <div class="col-md-3">

        <div class="form-group">
            {{Form::label('date', '開始日期')}}
            {{Form::date('date',null,['class' => 'form-control'])}}
        </div>
    </div>
    <div class="col-md-7">
        <div class="form-group">
            {{Form::label('prepare', '預算金額')}}
            {{Form::text('prepare',null,['class' => 'form-control'])}}
        </div>
    </div>
    <div class="col-md-2">

    <div class="form-group">
        @if(request()->segment(3)=='edit')
            {{Form::submit('修改案件',['class'=>'btn btn-success'])}}
        @else
            {{Form::submit('新增案件',['class'=>'btn btn-success'])}}
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
    @if($projects)
        <table class="table ">
            <tr><th>顧客</th><th>名稱</th><th>負責人</th><th>日期</th><th>預算金額</th><th>功能鍵</th></tr>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->title }}({{ $project->number }})</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->person }}</td>
                    <td>{{ $project->date }}</td>
                    <td>{{ $project->prepare }}</td>
                    <td>


                        {!! Form::open(['method' => 'DELETE', 'route' => ['project.destroy',$project->id],'onsubmit' => 'return confirm("確定要刪除嗎？")']) !!}
                        {{ Form::hidden('id', $project->id) }}
                        <a class="btn btn-info" href="{{ url("project/{$project->id}") }}">管理</a>
                        <a href="{{ url("project/{$project->id}/edit") }}"
                           class="btn btn-primary">修改</a>
                        {{ Form::submit('刪除', ['class' => 'btn btn-danger']) }}
                        {{ Form::close() }}


                    </td>
                </tr>
            @endforeach
        </table>
    @endif

</div>
@endsection
