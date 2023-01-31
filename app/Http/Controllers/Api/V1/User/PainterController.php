<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Painter;
use App\Column;
use App\Example;
use App\Evaluation;
use App\Services\PainterSearchService;

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
     * 業者検索
     *
     * @param  \App\Services\PainterSearchService  $search
     * @return \Illuminate\Http\Response
     */
    public function index(PainterSearchService $search)
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
        $painter = Painter::withCount([
                'evaluations' => function (Builder $query) {
                    $query->where('flg', Evaluation::EVALUATION_FLG_DONE);
                },
                'columns' => function (Builder $query) {
                    $query->where('public', Column::PUBLIC_ON);
                },
                'examples' => function (Builder $query) {
                    $query->where('public_consent', Example::PUBLIC_ON);
                },
            ])
            ->with('attachments')
            ->where('rank', '>=', Painter::RANK_MEMBER)
            ->where('id', $id)
            ->first();

        abort_if(!$painter, 403);

        return response()->json($painter->setAppends(Painter::$appendValues)->toArray());
    }

    /**
     * お気に入り業者
     *
     * @return \Illuminate\Http\Response
     */
    public function favorite()
    {
        $user = $this->guard()->user();
        $paginator = $user->favoritePainters()
            ->withCount([
                'evaluations' => function (Builder $query) {
                    $query->where('flg', Evaluation::EVALUATION_FLG_DONE);
                },
                'columns' => function (Builder $query) {
                    $query->where('public', Column::PUBLIC_ON);
                },
                'examples' => function (Builder $query) {
                    $query->where('public_consent', Example::PUBLIC_ON);
                },
            ])
            ->with('attachments')
            ->paginate(20); // TODO

        $paginator->getCollection()->map->setAppends(Painter::$appendValues);

        return $paginator;
    }
}
