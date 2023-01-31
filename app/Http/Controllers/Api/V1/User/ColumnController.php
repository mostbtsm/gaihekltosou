<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\ColumnSearchService;
use App\Painter;
use App\Column;

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
     * @param  \App\Services\ColumnSearchService  $search
     * @return \Illuminate\Http\Response
     */
    public function index(ColumnSearchService $search)
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
        $column = Column::with('attachments')
            ->where('public', Column::PUBLIC_ON)
            ->where('id', $id)
            ->first();

        abort_if(!$column, 403);

        return response()->json($column->setAppends(Column::$appendValues)->toArray());
    }

    /**
     * 業者のコラム取得
     */
    public function painter($id)
    {
        $painter = Painter::where([
            ['rank', '>=', Painter::RANK_MEMBER],
            ['id', '=', $id]
        ])->first();

        if ($painter) {
            $columns = $painter->columns()
                ->with('attachments')
                ->where('public', Column::PUBLIC_ON)
                ->orderby('updated_at', 'desc')
                ->get();

            $columns->map(function($item) {
                $item->setAppends(Column::$appendValues);
            });

            return response()->json($columns->toArray());
        }

        return response()->json([]);
    }
}
