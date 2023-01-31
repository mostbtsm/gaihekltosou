<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Favorite;
use App\Painter;

class FavoriteController extends Controller
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
        $user = $this->guard()->user();
        $favorites = $user->favorites()->orderBy('updated_at', 'desc')->get();

        return response()->json($favorites->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count = Painter::where('rank', '>=', Painter::RANK_MEMBER)
            ->where('id', $request->id)
            ->count();

        abort_if(!$count, 403);

        $favorite = new Favorite();
        $favorite->user_id = $this->guard()->id();
        $favorite->painter_id = $request->id;

        $favorite->save();

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->guard()->user();
        $favorite = $user->favorites()->where('painter_id', $id)->first();

        abort_if(!$favorite, 403);

        $favorite->delete();

        return response()->json();
    }
}
