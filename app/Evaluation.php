<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evaluation extends Model
{
    use SoftDeletes;

    const EVALUATION_FLG_NONE = 0; // 未評価
    const EVALUATION_FLG_DONE = 1; // 評価済

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'painter_id',
        'contract_id',
        'user_name',
        'quality',
        'price',
        'speed',
        'correspondence',
        'evaluation',
        'flg',
    ];

    /**
     * 評価済フラグのデフォルト値：0（未評価）
     *
     * @var array
     */
    protected $attributes = [
        'flg' => self::EVALUATION_FLG_NONE,
    ];

    /**
     * 業者
     *
     * @return Painter
     */
    public function painter()
    {
        return $this->belongsTo('App\Painter');
    }
}
