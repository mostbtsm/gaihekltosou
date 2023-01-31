<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Example extends Model
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
        'contract_id',
        'title',
        'address',
        'category',
        'property_type',
        'amount',
        'period',
        'comment',
        'public_consent',
    ];

    /**
     * 公開承諾フラグのデフォルト値：0（未承諾）
     *
     * @var array
     */
    protected $attributes = [
        'public_consent' => self::PUBLIC_OFF,
    ];

    /**
     * 完了日JSON項目
     */
    private $completeDateAttributes = [
        'year' => 1,
        'month' => 1,
    ];

    /**
     * 追加項目呼び出し用配列
     */
    public static $appendValues = [
        'warranties',
        'warranty_names',
        'complete_date',
        'categories',
        'category_names',
        'property_type_name',
        'amount_name',
        'period_name',
        'image_file1',
        'image_file2',
        'image_file3',
        'image_file4',
        'image_file5',
        'image_file6',
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
     * 業者情報
     *
     * @return array
     */
    public function getPainterInfoAttribute()
    {
        return [
            'id' => $this->painter->id,
            'name' => $this->painter->name,
        ];
    }

    /**
     * get warranty_json
     *
     * @return array
     */
    public function getWarrantyJsonAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * set warranty_json
     *
     * @param array
     */
    public function setWarrantyJsonAttribute(array $value)
    {
        $this->attributes['warranty_json'] = json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 保証内容
     *
     * @return array
     */
    public function getWarrantiesAttribute()
    {
        $data = $this->warranty_json;

        return array_filter($data);
    }

    /**
     * 表示用保証内容名
     *
     * @return array
     */
    public function getWarrantyNamesAttribute()
    {
        $result = [];
        $data = $this->warranties;

        if (isset($data['外壁塗装'])) {
            $result[] = "外壁塗装 $data[外壁塗装]年";
            unset($data['外壁塗装']);
        }

        if (isset($data['屋根塗装'])) {
            $result[] = "屋根塗装 $data[屋根塗装]年";
            unset($data['屋根塗装']);
        }

        if (isset($data['屋上防水'])) {
            $result[] = "屋上防水 $data[屋上防水]年";
            unset($data['屋上防水']);
        }

        if (isset($data['ベランダ防水'])) {
            $result[] = "ベランダ防水 $data[ベランダ防水]年";
            unset($data['ベランダ防水']);
        }

        foreach ($data as $key => $val) {
            $result[] = "{$key} {$val}年";
        }

        return $result;
    }

    /**
     * get complete_date_json
     *
     * @return array
     */
    public function getCompleteDateJsonAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * set complete_date_json
     *
     * @param array
     */
    public function setCompleteDateJsonAttribute(array $value)
    {
        $this->attributes['complete_date_json'] = json_encode(array_intersect_key($value, $this->completeDateAttributes));
    }

    /**
     * 完工日
     *
     * @param string
     */
    public function getCompleteDateAttribute()
    {
        $data = $this->complete_date_json;

        if (empty($data['year']) || empty($data['month'])) {
            return '';
        }

        return $data['year'] . '年' . $data['month'] . '月';
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
     * 建物タイプ名
     */
    public function getPropertyTypeNameAttribute()
    {
        $conf = config('const.select.property', []);

        return $conf[$this->attributes['property_type']] ?? '';
    }

    /**
     * 契約金額名
     */
    public function getAmountNameAttribute()
    {
        $conf = config('const.select.amount', []);

        return $conf[$this->attributes['amount']] ?? '';
    }

    /**
     * 工事期間名
     */
    public function getPeriodNameAttribute()
    {
        $conf = config('const.select.construction_period', []);

        return $conf[$this->attributes['period']] ?? '';
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

    /**
     * 画像5URL
     *
     * @return string
     */
    public function getImageFile5Attribute()
    {
        $attachment = $this->loadAttachments()->attachments->where('index', 5)->first();

        if ($attachment) {
            return $attachment->url;
        }

        return null;
    }

    /**
     * 画像6URL
     *
     * @return string
     */
    public function getImageFile6Attribute()
    {
        $attachment = $this->loadAttachments()->attachments->where('index', 6)->first();

        if ($attachment) {
            return $attachment->url;
        }

        return null;
    }
}
