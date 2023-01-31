<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Example;

class ExampleSearchService
{
    const PER_PAGE = 20; // 1回あたりのデフォルト取得数

    private $perPage;

    /**
     * コンストラクタ
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->perPage = self::PER_PAGE;
    }

    /**
     * クエリ生成・取得
     */
    private function getQuery()
    {
        $query = Example::with(['painter', 'attachments']);

        $query->where('public_consent', Example::PUBLIC_ON);

        $query->orderby('updated_at', 'desc');

        return $query;
    }

    /**
     * ペジネータ取得
     */
    public function paginate($perPage = null)
    {
        $paginator = $this->getQuery()->paginate($perPage ?? $this->perPage);

        $paginator->getCollection()->map->setAppends(array_merge(Example::$appendValues, ['painter_info']));

        return $paginator;
    }
}