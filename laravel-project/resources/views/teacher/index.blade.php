@extends('layouts.default')

@section('content')

<h1>{{$today->toDateString()}}</h1>
@foreach($attendances as $attendance)
<div class="attendance">
    <table>
        <tr>
            <th>名前：</th>
            <td>{{$attendance->user->name}}</td>
        </tr>
        <tr>
            <th>メールアドレス：</th>
            <td>{{$attendance->user->email}}</td>
        </tr>
    </table>
</div>

@endforeach

@endsection