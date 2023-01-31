<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\ExampleSearchService;
use App\Painter;
use App\Example;

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
     * @param  \App\Services\ExampleSearchService  $search
     * @return \Illuminate\Http\Response
     */
    public function index(ExampleSearchService $search)
    {
        return $search->paginate();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $example = Example::with('attachments')
            ->where('public_consent', Example::PUBLIC_ON)
            ->where('id', $id)
            ->first();

        abort_if(!$example, 403);

        return response()->json($example->setAppends(Example::$appendValues)->toArray());
    }

    /**
     * 業者の施工事例取得
     */
    public function painter($id)
    {
        $painter = Painter::where([
            ['rank', '>=', Painter::RANK_MEMBER],
            ['id', '=', $id]
        ])->first();

        if ($painter) {
            $examples = $painter->examples()
                ->with('attachments')
                ->where('public_consent', Example::PUBLIC_ON)
                ->orderby('updated_at', 'desc')
                ->get();

            $examples->map(function($item) {
                $item->setAppends(Example::$appendValues);
            });

            return response()->json($examples->toArray());
        }

        return response()->json([]);
    }
}
