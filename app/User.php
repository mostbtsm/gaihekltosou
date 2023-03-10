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

class User extends Model implements Authenticatable, CanResetPassword
{
    use SoftDeletes, Notifiable;

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
        $this->notify(new ResetPassword($token, 'users'));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name1',
        'name2',
        'kana1',
        'kana2',
        'nickname',
        'postal',
        'prefectures',
        'city',
        'address1',
        'address2',
        'tel',
        'mobile',
        'birth_date',
        'gender',
        'image_file',
        'type',
        'expiration_date',
        'card_info',
        'message_key',
    ];

    /**
     * ???????????????????????????
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'message_key',
    ];

    /**
     * ????????????????????????????????????0??????????????????
     *
     * @var array
     */
    protected $attributes = [
        'type' => 0,
    ];

    /**
     * ??????
     *
     * @return Property
     */
    public function properties()
    {
        return $this->hasMany('App\Property');
    }

    /**
     * ??????
     *
     * @return Request
     */
    public function requests()
    {
        return $this->hasMany('App\Request');
    }

    /**
     * ??????
     *
     * @return Contract
     */
    public function contracts()
    {
        return $this->hasMany('App\Contract');
    }

    /**
     * ???????????????
     *
     * @return Favorite
     */
    public function favorites()
    {
        return $this->hasMany('App\Favorite');
    }

    /**
     * ?????????????????????
     */
    public function favoritePainters()
    {
        return $this->belongsToMany('App\Painter', 'favorites')
            ->withPivot(['created_at'])
            ->orderBy('pivot_created_at', 'desc');
    }

    /**
     * ????????????????????????
     *
     * @return ChatThread
     */
    public function chatThreads()
    {
        return $this->hasMany('App\ChatThread');
    }

    /**
     * ?????????????????????
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * ???????????????
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->name1 . ' ' . $this->name2;
    }

    /**
     * ????????????????????????URL
     *
     * @return string
     */
    public function getProfileImageAttribute()
    {
        $value = $this->image_file;
        $storage = Storage::disk('profile_u');

        if ($storage->exists($value)) {
            return $storage->url($value);
        }

        return config('const.user_default_image');
    }

    /**
     * ????????????????????????????????????
     *
     * @return boolean
     */
    public function getProfileImageExistsAttribute()
    {
        $value = $this->image_file;
        $storage = Storage::disk('profile_u');

        return $storage->exists($value);
    }
}
