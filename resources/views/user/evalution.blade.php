@extends('layouts.app')


@section('title')
<a class="text-white page-title" href="#">評 価</a>
@endsection


@section('content')
<user-evaluation :evaluation_id="{{$evaluation_id}}" :painter_name="'{{$painter_name}}'"></user-evaluation>
@endsection