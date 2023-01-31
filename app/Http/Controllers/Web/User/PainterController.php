<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Painter;

class PainterController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            return redirect()->route('user.painter', $request->except(['_token', 'page']));
        }

        return view(config('const.template.user.painter'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $painter = Painter::where('rank', '>=', Painter::RANK_MEMBER)
            ->where('id', $id)
            ->first();

        abort_if(!$painter, 404);

        return view(config('const.template.user.painter_detail'), ['painter' => $painter]);
    }

    /**
     * 検索
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        return view(config('const.template.user.painter_search'), ['request' => $request]);
    }

    /**
     * お気に入り一覧
     *
     * @return \Illuminate\Http\Response
     */
    public function favorite()
    {
        return view(config('const.template.user.painter_favorite'));
    }
}
