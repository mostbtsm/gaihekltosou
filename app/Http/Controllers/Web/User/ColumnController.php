<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Column;
use App\Painter;

class ColumnController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    /**
     * Get the guard.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(config('const.template.user.column'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $column = Column::where('public', Column::PUBLIC_ON)
            ->where('id', $id)
            ->first();

        abort_if(!$column, 404);

        return view(config('const.template.user.column_detail'), ['column' => $column]);
    }

    /**
     * 業者コラム一覧
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function painter($id)
    {
        $painter = Painter::where('rank', '>=', Painter::RANK_MEMBER)
            ->where('id', $id)
            ->first();

        abort_if(!$painter, 404);

        return view(config('const.template.user.column_painter'), ['painter' => $painter]);
    }
}
