<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Date;

class ChatThread extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'painter_id',
        'user_read_at',
        'painter_read_at',
    ];

    /**
     * 日付を変形する属性
     *
     * @var array
     */
    protected $dates = [
        'user_read_at',
        'painter_read_at',
    ];

    /**
     * 追加項目呼び出し用配列
     */
    public static $appendValues = [
        'recent_message',
        'recent_message_time',
        'user_unread_count',
        'painter_unread_count',
        'user_profile_image',
        'painter_profile_image',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::creating(function($thread) {
            $now = Date::now();
            $thread->user_read_at = $now;
            $thread->painter_read_at = $now;
        });
    }

    /**
     * ユーザ
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * 業者
     *
     * @return Painter
     */
    public function painter()
    {
        return $this->belongsTo('App\Painter');
    }

    /**
     * ChatMessage
     *
     * @return ChatMessage
     */
    public function chatMessages()
    {
        return $this->hasMany('App\ChatMessage');
    }

    /**
     * ChatMessagesが読み込まれていなければ読み込んでおく
     */
    public function loadChatMessages()
    {
        if (!$this->attachments) {
            $this->load('chatMessages');
        }

        return $this;
    }

    /**
     * 最新メッセージ
     *
     * @return string
     */
    public function getRecentMessageAttribute()
    {
        $message = $this->loadChatMessages()->chatMessages->sortByDesc('created_at')->first();

        return $message ? $message->contents : '';
    }

    /**
     * 最新メッセージ日時
     *
     * @return string
     */
    public function getRecentMessageTimeAttribute()
    {
        $message = $this->loadChatMessages()->chatMessages->sortByDesc('created_at')->first();

        return $message ? $message->created_at->format('Y-m-d H:i') : '';
    }

    /**
     * ユーザ未読メッセージカウント
     *
     * @return int
     */
    public function getUserUnreadCountAttribute()
    {
        return $this->loadChatMessages()->chatMessages
            ->where('message_key', '!=', $this->user->message_key)
            ->where('created_at', '>=', $this->user_read_at)
            ->count();
    }

    /**
     * 業者未読メッセージカウント
     *
     * @return int
     */
    public function getPainterUnreadCountAttribute()
    {
        return $this->loadChatMessages()->chatMessages
            ->where('message_key', '!=', $this->painter->message_key)
            ->where('created_at', '>=', $this->painter_read_at)
            ->count();
    }

    /**
     * ユーザ画像URL
     *
     * @return string
     */
    public function getUserProfileImageAttribute()
    {
        return $this->user->profile_image;
    }

    /**
     * 業者画像URL
     *
     * @return string
     */
    public function getPainterProfileImageAttribute()
    {
        return $this->painter->profile_image;
    }
}
