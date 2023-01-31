<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Attachment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'location',
        'mimetype',
        'storage',
        'index',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::deleted(function($attachment) {
            $attachment->ifExistsDelete();
        });
    }

    /**
     * ファイルURL
     */
    public function getUrlAttribute()
    {
        return Storage::disk($this->storage)->url($this->location);
    }

    /**
     * ファイルがあれば削除する
     */
    public function ifExistsDelete()
    {
        $storage = Storage::disk($this->storage);

        if ($storage->exists($this->location)) {
            $storage->delete($this->location);
        }
    }
}
