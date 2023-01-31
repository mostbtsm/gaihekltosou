<?php

namespace App\Http\Controllers\Web\Painter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ColumnController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:painter');
    }

    /**
     * Get the guard.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('painter');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $painter = $this->guard()->user();
        $count = $painter->columns()->count();
        $createBtnDisable = $count >= 3;

        return view(config('const.template.painter.column'), ['createBtnDisable' => $createBtnDisable]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $painter = $this->guard()->user();
        $count = $painter->columns()->count();
        abort_if($count >= 3, 403); // TODO 最大登録数の定義場所を決める

        return view(config('const.template.painter.column_create'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $painter = $this->guard()->user();
        $column = $painter->columns()->where('id', $id)->first();
        abort_if(!$column, 403);

        return view(config('const.template.painter.column_edit'), ['column' => $column]);
    }
}
