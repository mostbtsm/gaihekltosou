<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'subject',
        'contents',
        'send_flg',
    ];

    /**
     * 送信済みフラグのデフォルト値：0（未送信）
     *
     * @var array
     */
    protected $attributes = [
        'send_flg' => 0,
    ];
}
