<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Column extends Model
{
    use SoftDeletes;

    const PUBLIC_OFF = 0; // 未公開
    const PUBLIC_ON  = 1; // 公開

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'painter_id',
        'title',
        'category',
        'contents',
        'public',
    ];

    /**
     * 追加項目呼び出し用配列
     */
    public static $appendValues = [
        'image_file1',
        'image_file2',
        'image_file3',
        'image_file4',
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
