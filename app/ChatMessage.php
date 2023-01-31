<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ChatMessage extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'chat_thread_id',
        'contents',
        'attachment_id',
        'message_key',
    ];

    /**
     * 配列に含めない属性
     *
     * @var array
     */
    protected $hidden = [
        'message_key',
    ];

    /**
     * 追加項目呼び出し用配列
     */
    public static $appendValues = [
        'messaged_at',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::created(function($message) {
            $message->chatThread()->touch();
        });
    }

    /**
     * ChatThread
     *
     * @return ChatThread
     */
    public function chatThread()
    {
        return $this->belongsTo('App\ChatThread');
    }

    /**
     * Attachment
     *
     * @return Attachment
     */
    public function attachment()
    {
        return $this->belongsTo('App\Attachment');
    }

    /**
     * 表示メッセージ日時
     *
     * @return string
     */
    public function getMessagedAtAttribute()
    {
        return $this->created_at->format('Y-m-d H:i');
    }
}
