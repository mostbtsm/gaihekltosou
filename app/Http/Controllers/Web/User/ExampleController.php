<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Example;
use App\Painter;

class ExampleController extends Controller
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
        return view(config('const.template.user.example'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $example = Example::where('public_consent', Example::PUBLIC_ON)
            ->where('id', $id)
            ->first();

        abort_if(!$example, 404);

        return view(config('const.template.user.example_detail'), ['example' => $example]);
    }

    /**
     * 業者施工事例一覧
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

        return view(config('const.template.user.example_painter'), ['painter' => $painter]);
    }
}
