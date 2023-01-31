<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Painter;
use App\Column;
use App\Example;
use App\Evaluation;

class PainterSearchService
{
    const PER_PAGE = 20; // 1回あたりのデフォルト取得数

    private $perPage;

    private $prefecture = '';

    private $city = '';

    /**
     * コンストラクタ
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->perPage = self::PER_PAGE;

        $this->prefecture = $request->get('prefecture', '');
        $this->city = $request->get('city', '');
    }

    /**
     * クエリ生成・取得
     */
    private function getQuery()
    {
        $query = Painter::withCount([
            'evaluations' => function (Builder $query) {
                $query->where('flg', Evaluation::EVALUATION_FLG_DONE);
            },
            'columns' => function (Builder $query) {
                $query->where('public', Column::PUBLIC_ON);
            },
            'examples' => function (Builder $query) {
                $query->where('public_consent', Example::PUBLIC_ON);
            },
        ]);

        $query->with(['attachments']);

        if (strlen($this->prefecture)) {
            $query->where('prefectures', $this->prefecture);
        }

        if (strlen($this->city)) {
            $query->where(function($q) {
                $q->where('city', 'like', '%' . mb_convert_kana($this->city, 'aCKV') . '%')
                  ->orWhere('city', 'like', $this->city);
            });
        }

        $query->where('rank', '>=', Painter::RANK_MEMBER);

        $query->orderby('id', 'asc');

        return $query;
    }

    /**
     * ペジネータ取得
     */
    public function paginate($perPage = null)
    {
        $paginator = $this->getQuery()->paginate($perPage ?? $this->perPage);

        $paginator->getCollection()->map->setAppends(Painter::$appendValues);

        return $paginator;
    }
}