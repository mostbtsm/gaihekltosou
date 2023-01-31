<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword;
use Storage;
use Hash;

class Painter extends Model implements Authenticatable, CanResetPassword
{
    use SoftDeletes, Notifiable;

    const RANK_UNAUTHORIZED = 0; // 未承認
    const RANK_MEMBER = 1;       // 無料会員

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->id;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        //
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        //
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        //
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token, 'painters'));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'kana',
        'ceo_name',
        'type',
        'postal',
        'prefectures',
        'city',
        'address1',
        'address2',
        'tel',
        'fax',
        'charge_name1',
        'charge_name2',
        'charge_kana1',
        'charge_kana2',
        'charge_tel',
        'charge_email',
        'url',
        'established',
        'capital',
        'permission',
        'organization',
        'sales',
        'employees',
        'social_insurance',
        'accident_insurance',
        'other_insurance',
        'category',
        'image_file',
        'catch_copy',
        'constructions',
        'annual_constructions',
        'rank',
        'pr_copy',
        'message_key',
    ];

    /**
     * 配列に含めない属性
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'message_key',
    ];

    /**
     * ランクのデフォルト値：0
     *
     * @var array
     */
    protected $attributes = [
        'rank' => 0,
    ];

    /**
     * 追加項目呼び出し用配列
     */
    public static $appendValues = [
        'prefecture_name',
        'category_names',
        'profile_image',
        'image_file1',
        'image_file2',
        'image_file3',
        'image_file4',
    ];

    /**
     * 施工事例
     *
     * @return Example
     */
    public function examples()
    {
        return $this->hasMany('App\Example');
    }

    /**
     * コラム
     *
     * @return Column
     */
    public function columns()
    {
        return $this->hasMany('App\Column');
    }

    /**
     * 提案
     *
     * @return Proposal
     */
    public function proposals()
    {
        return $this->hasMany('App\Proposal');
    }

    /**
     * 契約
     *
     * @return Contract
     */
    public function contracts()
    {
        return $this->hasMany('App\Contract');
    }

    /**
     * 評価
     *
     * @return Evaluation
     */
    public function evaluations()
    {
        return $this->hasMany('App\Evaluation');
    }

    /**
     * お気に入り業者
     *
     * @return Favorite
     */
    public function favorites()
    {
        return $this->hasMany('App\Favorite');
    }

    /**
     * チャットスレッド
     *
     * @return ChatThread
     */
    public function chatThreads()
    {
        return $this->hasMany('App\ChatThread');
    }

    /**
     * 画像ファイル
     *
     * @return Image
     */
    public function images()
    {
        return $this->hasMany('App\Image');
    }

    /**
     * ファイル
     *
     * @return Attachment
     */
    public function attachments()
    {
        return $this->belongsToMany('App\Attachment');
    }

    /**
     * Attachmentsが読み込まれていなければ読み込んでおく
     */
    public function loadAttachments()
    {
        if (!$this->attachments) {
            $this->load('attachments');
        }

        return $this;
    }

    /**
     * パスワード設定
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * 都道府県名
     *
     * @return string
     */
    public function getPrefectureNameAttribute()
    {
        if (isset($this->prefectures)) {
            return config('const.select.prefecture')[$this->prefectures];
        }

        return '';
    }

    /**
     * カテゴリ登録
     */
    public function setCategoriesAttribute(array $value)
    {
        $this->attributes['category'] = implode(',', $value);
    }

    /**
     * カテゴリ取得
     */
    public function getCategoriesAttribute()
    {
        return explode(',', $this->attributes['category']);
    }

    /**
     * カテゴリ名取得
     */
    public function getCategoryNamesAttribute()
    {
        $categories = $this->categories;
        $conf = config('const.select.category', []);

        return array_values(array_filter($conf, function($key) use($categories) {
            return in_array($key, $categories);
        }, ARRAY_FILTER_USE_KEY));
    }

    /**
     * プロフィール画像URL
     *
     * @return string
     */
    public function getProfileImageAttribute()
    {
        $value = $this->image_file;
        $storage = Storage::disk('profile_p');

        if ($storage->exists($value)) {
            return $storage->url($value);
        }

        return config('const.no_image');
    }

    /**
     * プロフィール画像があるか
     *
     * @return boolean
     */
    public function getProfileImageExistsAttribute()
    {
        $value = $this->image_file;
        $storage = Storage::disk('profile_p');

        return $storage->exists($value);
    }

    /**
     * 画像1URL
     *
     * @return string
     */
    public function getImageFile1Attribute()
    {
        $attachment = $this->loadAttachments()->attachments->where('index', 1)->first();

        if ($attachment) {
            return $attachment->url;
        }

        return null;
    }

    /**
     * 画像2URL
     *
     * @return string
     */
    public function getImageFile2Attribute()
    {
        $attachment = $this->loadAttachments()->attachments->where('index', 2)->first();

        if ($attachment) {
            return $attachment->url;
        }

        return null;
    }

    /**
     * 画像3URL
     *
     * @return string
     */
    public function getImageFile3Attribute()
    {
        $attachment = $this->loadAttachments()->attachments->where('index', 3)->first();

        if ($attachment) {
            return $attachment->url;
        }

        return null;
    }

    /**
     * 画像4URL
     *
     * @return string
     */
    public function getImageFile4Attribute()
    {
        $attachment = $this->loadAttachments()->attachments->where('index', 4)->first();

        if ($attachment) {
            return $attachment->url;
        }

        return null;
    }
}
