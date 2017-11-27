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
        <table class="table">
            <tr><th>建立收據</th></tr>
            <tr><td>收據表單</td></tr>
        </table>
    </div>
@endsection
