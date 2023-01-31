@extends('layouts.app')
@section('content')

<div id="app">
    <div class="form-container bussiness-form">
        <business-discussion user-id="{{ $user_id }}"></business-discussion>
    </div>
</div>
 
<div>
    <div class="back-button"><a href="{{ $url }}"  class="text-white btn-regester text-center">戻  る</a></div>
</div>

@endsection