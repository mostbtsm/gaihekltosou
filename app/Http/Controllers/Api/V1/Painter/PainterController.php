<?php

namespace App\Http\Controllers\Api\V1\Painter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\PainterEntryRequest;
use App\Http\Requests\PainterEditRequest;
use App\Painter;
use Image;
use App\Http\Middleware\ImageFilter;
use Storage;
use App\Image as ImageTable;
use App\Http\Requests\PropertyRequest;
use App\Example;
use App\Property;
use App\Contract;
use Mail;
use App\Mail\Entry;
use App\Mail\Contact;
use App\Column;
use App\Attachment;

class PainterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:painter')->except(['entry', 'login']);
    }

    /**
     * Get the guard.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('painter');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request\PainterEntryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function entry(PainterEntryRequest $request)
    {
        $painter = new Painter();

        $painter->email = $request->email;
        $painter->password = $request->password;
        $painter->name = $request->name;
        $painter->message_key = md5(uniqid(rand(), true));  // チャットメッセージの発信元を特定するキー

        $painter->save();

        $id = $painter->id;
        $name = $painter->name;
        $email = $painter->email;

        $template = 'entry_admin';
        $subject = '会員登録完了通知';
        Mail::to(config('mailsending.entry.send_to_admin'))->send(new Entry($template, $subject, $id, $email, $name));

        $template = 'entry_painter';
        $subject = '会員登録ありがとうございます';
        Mail::to($email)->send(new Entry($template, $subject, $email, $id, $name));

        return response()->json([
            'next' => route('painter.complete')
        ]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // バリデーション
        $request->validate([
            'email' => 'required|email|max:256',
            'password' => 'required|string|min:8|max:256|alpha_dash',
        ]);

        // 認証処理
        $credentials = $request->only('email', 'password');

        if (Auth::guard('painter')->attempt($credentials)) {
            return response()->json([
                'next' => route('painter.mypage')
            ]);
        }

        return response()->json([
            'errors' => [
                'email' => [__('auth.failed')]
            ]
        ], 401);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $painter = Painter::find($this->guard()->id());

        return response()->json($painter->setAppends(Painter::$appendValues)->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request\PainterEditRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(PainterEditRequest $request)
    {
        $painter = $this->guard()->user();

        $painter->email = $request->email;
        $painter->name = $request->name;
        $painter->kana = $request->kana;
        $painter->ceo_name = $request->ceo_name;
        $painter->type = $request->type;
        $painter->postal = $request->postal;
        $painter->prefectures = $request->prefectures;
        $painter->city = $request->city;
        $painter->address1 = $request->address1;
        $painter->address2 = $request->address2;
        $painter->tel = $request->tel;
        $painter->fax = $request->fax;

        $painter->established = $request->established;
        //$painter->capital = $request->capital;
        //$painter->permission = $request->permission;
        $painter->organization = $request->organization;
        $painter->sales = $request->sales;
        //$painter->employees = $request->employees;

        //$painter->category = $request->category;
        if (is_array($request->category)) {
            $painter->categories = $request->category;
        } else {
            $painter->category = $request->category;
        }
        $painter->catch_copy = $request->catch_copy;
        $painter->pr_copy = $request->pr_copy;

        $painter->save();

        $storage = Storage::disk('image_p');

        for ($i = 1; $i <= 4; $i++) {
            $field = 'image_file' . $i;
            $attachment = $painter->loadAttachments()->attachments->where('index', $i)->first();

            // 画像ファイル保存処理
            if ($request->hasFile($field)) {
                $filename = md5(uniqid(rand(), true)) . '.jpg';
                $file = $request->file($field);
                $image = Image::make($file)->filter(new ImageFilter());

                if ($storage->put($filename, $image)) {
                    if ($attachment) {
                        // 新しい画像がアップロードされた場合、登録済みの画像ファイルがあれば削除する
                        $attachment->ifExistsDelete();
                    } else {
                        $attachment = new Attachment();
                    }

                    $attachment->fill([
                        'location' => $filename,
                        'mimetype' => $image->mime(),
                        'storage'  => 'image_p',
                        'index'    => $i,
                    ]);

                    $attachment->save();
                    $painter->attachments()->syncWithoutDetaching($attachment->id);
                }
            } elseif ($request->boolean('del_flg' . $i) && $attachment) {
                // 登録済みの画像ファイルがある場合、明示的に削除指定されていれば削除する
                $attachment->delete();
            }
        }

        return response()->json([
            'next' => route('painter.mypage')
        ]);
    }

    /**
     * プロフィール画像アップロード
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadImage(Request $request)
    {
        $max_size = config('const.image.max_size');

        // バリデーション
        $request->validate([
            'image_file' => "required|file|image|max:{$max_size}|mimes:jpg,jpeg,gif,png",
        ]);

        $painter = $this->guard()->user();
        $storage = Storage::disk('profile_p');

        // リサイズ画像を保存
        $filename = md5(uniqid(rand(), true)) . '.jpg';
        $file = $request->image_file;
        $image = Image::make($file)->filter(new ImageFilter());

        if ($storage->put($filename, $image)) {
            // 新しい画像がアップロードされた場合、登録済みの画像ファイルがあれば削除する
            if ($storage->exists($painter->image_file)) {
                $storage->delete($painter->image_file);
            }

            $painter->image_file = $filename;
            $painter->save();
        }

        return response()->json([
            'profile_image' => $painter->profile_image,
        ]);
    }

    /**
     * プロフィール画像削除
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteImage()
    {
        $painter = Painter::find($this->guard()->id());

        $storage = Storage::disk('profile_p');
        if ($storage->exists($painter->image_file)) {
            $storage->delete($painter->image_file);
            $painter->image_file = null;
            $painter->save();
        }

        return response()->json([
            'profile_image' => config('const.no_image'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request\PropertyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PropertyRequest $request)
    {

        $pid = $this->guard()->id();
        $painter = Painter::find($pid);

        // 現在の登録画像を取得
        $imageDB = ImageTable::where('painter_id', '=', $pid);

        // ID順
        $imageDB = $imageDB->orderby('id', 'asc');

        $array = $imageDB->select('id')->get();
        $array_length = count($array);

        $storage = Storage::disk('profile_p');

        for ($i = 1; $i <= 6; $i++) {

            $imageStore = new ImageTable();

            if ($array_length < $i ){
                //新規登録
                $imageStore->painter_id = $pid;
            } else {
                //上書き登録
                $imageStore = ImageTable::find($array[$i - 1]);
            }

            $field = 'image_file' . $i;
            $prop = 'image' . $i;


            // 画像ファイル保存処理
            if ($request->hasFile($field)) {

                $filename = md5(uniqid(rand(), true)) . '.jpg';
                $file = $request->file($field);
                $image =Image::make($file)->filter(new ImageFilter());

                if ($storage->put($filename, $image)) {
                    // 登録済みの画像ファイルがあれば削除する
                    if ($storage->exists($imageStore->image_file)) {
                        $storage->delete($imageStore->image_file);
                    }

                    //プロフィール画像指定
                    //todo 現状はとりあえず１番目を指定
                    if ($i == 1) {
                        $imageStore->flg = 1;

                        $painter->image_file = $filename;
                        $painter->save();

                    } else {
                        $imageStore->flg = 0;
                    }

                    $imageStore->image_file = $filename;
                    $imageStore->save();
                }
            }
        }

        return response()->json();
    }

    /**
     * 画像取得
     *
     * @return \Illuminate\Http\Response
     */
    public function images()
    {
        $pid = $this->guard()->id();

        // 現在の登録画像を取得
        $imageDB = ImageTable::where('painter_id', '=', $pid);

        // ID順
        $imageDB = $imageDB->orderby('id', 'asc');

        return $imageDB->select('image_file')->get();
    }

    /**
     * 画像URL取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function imageurl(Request $request)
    {
        $storage = Storage::disk('profile_p');

        $image_file = $request->input('image_file', '');
        if ($storage->exists($image_file)) {
            return response()->json([
                'image_file' => $storage->url($image_file),
            ]);
        }

        return config('const.no_image');
    }

    /**
     * サイト外施工事例新規作成処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exampleentry(Request $request)
    {
        // 物件データを追加
        $property_id = Property::insertGetId([
            'user_id' => 0,
            'name' => $request->name,
            'address' => $request->address,
            'area' => $request->area,
            'area_b' => $request->area_b,
            'floors' => $request->floors,
            'age' => $request->age,
            'type' => $request->type,
            'type_wall' => $request->type_wall,
            'type_roof' => $request->type_roof
        ]);

        // 契約データを追加
        $contract_id = Contract::insertGetId([
            'user_id' => 0,
            'property_id' => $property_id,
            'request_id' => 0,
            'painter_id' => $this->guard()->id(),
            'category' => $request->category,
            'plan' => $request->plan,
            'period' => $request->period,
            'paint' => $request->paint,
            'memo' => $request->memo,
            'complete_date' => $request->complete_date,
            'amount' => $request->amount,
            'warranty_title' => $request->warranty_title,
            'warranty' => $request->warranty
        ]);
        // 施工事例データを追加
        $example = new Example();

        $example->painter_id = $this->guard()->id();
        $example->contract_id = $contract_id;

        $storage = Storage::disk('example');

        for ($i = 1; $i <= 6; $i++) {
            $filename = '';
            $field = 'image_file' . $i;

            // 画像ファイル保存処理
            if ($request->hasFile($field)) {
                // リサイズ画像を保存
                $filename = md5(uniqid(rand(), true)) . '.jpg';
                $file = $request->file($field);
                $image = Image::make($file)->filter(new ImageFilter());

                if ($storage->put($filename, $image)) {

                    $example->fill([$field => $filename]);
                }

            }

        }

        $example->comment = $request->comment;

        // とりあえず強制公開
//        $example->public_consent = $request->public_consent;
        $example->public_consent = 1;

        $example->save();

        // return Example::where('painter_id', $this->guard()->id())->get();
        return response()->json([
            'next' => route('painter.mypage')
        ]);
    }

    /**
     * お問い合わせページ
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function inquiry(Request $request)
    {
        // バリデーション
        $request->validate([
            'confirmed' => 'nullable|boolean',
            'contents'  => 'required|string|max:2048',
        ]);

        if ($request->input('confirmed', false)) {
            // メール送信処理
            $painter = $this->guard()->user();

            $name = $painter->name;
            $email = $painter->email;
            $contents = $request->input('contents');
            $userType = '企業';

            $template = 'contact_admin';
            $subject = 'お問い合わせ送信通知';
            Mail::to(config('mailsending.contact.send_to_admin'))->send(new Contact($template, $userType, $subject, $email, $name, $contents));

            $template = 'contact_user';
            $subject = 'お問い合わせありがとうございます';
            Mail::to($email)->send(new Contact($template, $userType, $subject, $email, $name, $contents));
        }

        return response()->json();
    }

    /**
     * パスワード更新
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        // バリデーション
        $request->validate([
            'old_password' => 'required|password:painter',
            'new_password' => 'required|string|min:8|max:256|alpha_dash|confirmed',
        ]);

        $painter = $this->guard()->user();
        $painter->password = $request->input('new_password');
        $painter->save();

        return response()->json();
    }

    /**
     * 退会
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function withdraw(Request $request)
    {
        // バリデーション
        $request->validate([
            'confirmed' => 'nullable|boolean',
            'password' => 'password:painter',
        ]);

        if ($request->input('confirmed', false)) {
            Painter::destroy($this->guard()->id());
            $this->guard()->logout();
        }

        return response()->json([
            'next' => route('top'),
        ]);
    }

    /**
     * コラム登録
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function columnstore(Request $request)
    {
        $column = new Column();

        $column->painter_id = $this->guard()->id();
        $column->title = $request->title;

        $category = $request->input('category', 0);
        $column->category = $category;

        $storage = Storage::disk('column');

        for ($i = 1; $i <= 6; $i++) {
            $filename = '';
            $field = 'image_file' . $i;

            // 画像ファイル保存処理
            if ($request->hasFile($field)) {
                // リサイズ画像を保存
                $filename = md5(uniqid(rand(), true)) . '.jpg';
                $file = $request->file($field);
                $image = Image::make($file)->filter(new ImageFilter());

                if ($storage->put($filename, $image)) {

                    $column->fill([$field => $filename]);
                }

            }

        }

        $column->contents = $request->contents;

        // とりあえず強制公開
//        $column->public = $request->public;
        $column->public = 1;

        $column->save();

        return response()->json([
            'next' => route('painter.column_list')
        ]);

    }

    /**
     * 業者情報取得（コラム）
     *
     * @return \Illuminate\Http\Response
     */
    public function getpainterinfo()
    {
        $painter = Painter::where('id', $this->guard()->id());

        $array = $painter->get();
        $array_length = count($array);

        $storage = Storage::disk('profile_p');

        for ($i = 0; $i < $array_length; $i++) {
          if ($storage->exists($array[$i]->image_file)) {
            $array[$i]->image_file = $storage->url($array[$i]->image_file);
          }
        }
        return $array;

    }

    /**
     * 施工事例登録リンク
     *
     * @return \Illuminate\Http\Response
     */
    public function getexampleentrylink()
    {
        return response()->json([
            'next' => route('painter.exampleentry')
        ]);
    }

    /**
     * コラム登録リンク
     *
     * @return \Illuminate\Http\Response
     */
    public function getcolumnlink()
    {
        return response()->json([
            'next' => route('column.create')
        ]);
    }

    /**
     * 施工事例データ取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function examplelist(Request $request)
    {
        // データ取得
        $example = Example::where('examples.painter_id', $this->guard()->id());

        // 契約、業者JOIN
        $example = $example->join('contracts', 'examples.contract_id', '=', 'contracts.id')
            ->join('properties', 'contracts.property_id', '=', 'properties.id')
            ->select('examples.*','properties.name','properties.type','properties.address','properties.area','properties.area_b','properties.floors','properties.age','properties.type_wall','properties.type_roof','contracts.category','contracts.period','contracts.warranty','contracts.plan','contracts.paint','contracts.memo','contracts.complete_date','contracts.amount','contracts.contract_amount','contracts.warranty_title');

        // １回あたりの表示件数
        $limit = $request->input('limit', 20);
        // 取得位置
        $skip = $request->input('skip', 0);

        // 最新のデータから順に取得
        $example = $example->orderby('examples.updated_at', 'desc');

        // 表示件数分取得
        $example = $example->skip($skip)->limit($limit);

        // return $example;
//        return $example->get();
        $array = $example->get();
        $array_length = count($array);

        $storage = Storage::disk('example');

        for ($i = 0; $i < $array_length; $i++) {
          if ($storage->exists($array[$i]->image_file1)) {
            $array[$i]->image_file1 = $storage->url($array[$i]->image_file1);
          }
          if ($storage->exists($array[$i]->image_file2)) {
            $array[$i]->image_file2 = $storage->url($array[$i]->image_file2);
          }
          if ($storage->exists($array[$i]->image_file3)) {
            $array[$i]->image_file3 = $storage->url($array[$i]->image_file3);
          }
          if ($storage->exists($array[$i]->image_file4)) {
            $array[$i]->image_file4 = $storage->url($array[$i]->image_file4);
          }
          if ($storage->exists($array[$i]->image_file5)) {
            $array[$i]->image_file5 = $storage->url($array[$i]->image_file5);
          }
          if ($storage->exists($array[$i]->image_file6)) {
            $array[$i]->image_file6 = $storage->url($array[$i]->image_file6);
          }

        }

        // return $column;
        return $array;
    }

    /**
     * 施工事例更新処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exampleupload(Request $request)
    {
        // 施工事例データを検索
//        $example = new Example();
        $example = Example::find($request->id);
        $contract_id = $example->contract_id;

        // 契約データを検索
        $contract = Contract::find($contract_id);
        $property_id = $contract->property_id;

        // データのないものは上書きしない
        $contract->category = $request->category;
//        $contract->plan = $request->plan;
        $contract->period = $request->period;
//        $contract->paint = $request->paint;
//        $contract->memo = $request->memo;
        $contract->complete_date = $request->complete_date;
        $contract->amount = $request->amount;
        $contract->warranty_title = $request->warranty_title;
        $contract->warranty = $request->warranty;


        // 物件データを検索
        $property = Property::find($property_id);

        // データのないものは上書きしない
        $property->name = $request->name;
        $property->address = $request->address;
//        $property->area = $request->area;
//        $property->area_b = $request->area_b;
//        $property->floors = $request->floors;
//        $property->age = $request->age;
        $property->type = $request->type;
//        $property->type_wall = $request->type_wall;
//        $property->type_roof = $request->type_roof;

        $storage = Storage::disk('example');

        for ($i = 1; $i <= 6; $i++) {
            $filename = '';
            $field = 'image_file' . $i;

            // 画像ファイル保存処理
            if ($request->hasFile($field)) {
                // リサイズ画像を保存
                $filename = md5(uniqid(rand(), true)) . '.jpg';
                $file = $request->file($field);
                $image = Image::make($file)->filter(new ImageFilter());


                if ($storage->put($filename, $image)) {

                    // 登録済みの画像ファイルがあれば削除する
                    switch ($i){
                    case 1:
                      if ($storage->exists($example->image_file1)) {
                          $storage->delete($example->image_file1);
                      }
                      break;
                    case 2:
                      if ($storage->exists($example->image_file2)) {
                          $storage->delete($example->image_file2);
                      }
                      break;
                    case 3:
                      if ($storage->exists($example->image_file3)) {
                          $storage->delete($example->image_file3);
                      }
                      break;
                    case 4:
                      if ($storage->exists($example->image_file4)) {
                          $storage->delete($example->image_file4);
                      }
                      break;
                    case 5:
                      if ($storage->exists($example->image_file5)) {
                          $storage->delete($example->image_file5);
                      }
                      break;
                    case 6:
                      if ($storage->exists($example->image_file6)) {
                          $storage->delete($example->image_file6);
                      }
                      break;
                    }

                    $example->fill([$field => $filename]);
                }

            }

        }

        $example->comment = $request->comment;

        // とりあえず強制公開
//        $example->public_consent = $request->public_consent;
        $example->public_consent = 1;

        // 上書き保存
        $property->save();
        $contract->save();
        $example->save();

        // return Example::where('painter_id', $this->guard()->id())->get();
        return response()->json([
            'next' => route('painter.construction_case_list')
        ]);
    }

    /**
     * 施工事例削除
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteexample(Request $request)
    {
        $eid = $request->id;
        $example = Example::find($eid);

        // 登録済みの画像ファイルがあれば削除する
        $storage = Storage::disk('example');
        if ($storage->exists($example->image_file1)) {
            $storage->delete($example->image_file1);
        }
        if ($storage->exists($example->image_file2)) {
            $storage->delete($example->image_file2);
        }
        if ($storage->exists($example->image_file3)) {
            $storage->delete($example->image_file3);
        }
        if ($storage->exists($example->image_file4)) {
            $storage->delete($example->image_file4);
        }
        if ($storage->exists($example->image_file5)) {
            $storage->delete($example->image_file5);
        }
        if ($storage->exists($example->image_file6)) {
            $storage->delete($example->image_file6);
        }

//        $example = Example::where('id', $eid);
        $example->delete();

        return response()->json([
            'next' => route('painter.construction_case_list')
        ]);

    }

    /**
     * コラム取得
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getcolumn(Request $request)
    {

        // １回あたりの表示件数
        $limit = $request->input('limit', 0);
        $painter_id = $this->guard()->id();

        // データ検索
        $column = Column::where('painter_id', $painter_id);

        // １回あたりの表示件数
        $limit = $request->input('limit', 20);
        // 取得位置
        $skip = $request->input('skip', 0);

        // 最新のデータから順に取得
        $column = $column->orderby('columns.updated_at', 'desc');

        // 表示件数分取得
        $column = $column->skip($skip)->limit($limit);

        $array = $column->get();
        $array_length = count($array);

        $storage = Storage::disk('column');

        for ($i = 0; $i < $array_length; $i++) {
          if ($storage->exists($array[$i]->image_file1)) {
            $array[$i]->image_file1 = $storage->url($array[$i]->image_file1);
          }
          if ($storage->exists($array[$i]->image_file2)) {
            $array[$i]->image_file2 = $storage->url($array[$i]->image_file2);
          }
          if ($storage->exists($array[$i]->image_file3)) {
            $array[$i]->image_file3 = $storage->url($array[$i]->image_file3);
          }
          if ($storage->exists($array[$i]->image_file4)) {
            $array[$i]->image_file4 = $storage->url($array[$i]->image_file4);
          }
          if ($storage->exists($array[$i]->image_file5)) {
            $array[$i]->image_file5 = $storage->url($array[$i]->image_file5);
          }
          if ($storage->exists($array[$i]->image_file6)) {
            $array[$i]->image_file6 = $storage->url($array[$i]->image_file6);
          }

        }

        // return $column;
        return $array;

    }

    /**
     * コラム更新処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function columnupload(Request $request)
    {
        $column = Column::find($request->id);
        // データのないものは上書きしない

        $column->title = $request->title;

        $category = $request->input('category', 0);
        if ($category != 0) {
          $column->category = $category;
        }

        $storage = Storage::disk('column');

        for ($i = 1; $i <= 6; $i++) {
            $filename = '';
            $field = 'image_file' . $i;

            // 画像ファイル保存処理
            if ($request->hasFile($field)) {
                // リサイズ画像を保存
                $filename = md5(uniqid(rand(), true)) . '.jpg';
                $file = $request->file($field);
                $image = Image::make($file)->filter(new ImageFilter());

                if ($storage->put($filename, $image)) {

                    // 登録済みの画像ファイルがあれば削除する
                    switch ($i){
                    case 1:
                      if ($storage->exists($column->image_file1)) {
                          $storage->delete($column->image_file1);
                      }
                      break;
                    case 2:
                      if ($storage->exists($column->image_file2)) {
                          $storage->delete($column->image_file2);
                      }
                      break;
                    case 3:
                      if ($storage->exists($column->image_file3)) {
                          $storage->delete($column->image_file3);
                      }
                      break;
                    case 4:
                      if ($storage->exists($column->image_file4)) {
                          $storage->delete($column->image_file4);
                      }
                      break;
                    case 5:
                      if ($storage->exists($column->image_file5)) {
                          $storage->delete($column->image_file5);
                      }
                      break;
                    case 6:
                      if ($storage->exists($column->image_file6)) {
                          $storage->delete($column->image_file6);
                      }
                      break;
                    }

                    $column->fill([$field => $filename]);
                }

            }

        }

        $column->contents = $request->contents;

        // とりあえず強制公開
//        $column->public = $request->public;
        $column->public = 1;

        $column->save();

        return response()->json([
            'next' => route('painter.column_list')
        ]);

    }

    /**
     * コラム削除
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deletecolumn(Request $request)
    {
        $cid = $request->id;
        $column = Column::find($cid);

        // 登録済みの画像ファイルがあれば削除する
        $storage = Storage::disk('column');
        if ($storage->exists($column->image_file1)) {
            $storage->delete($column->image_file1);
        }
        if ($storage->exists($column->image_file2)) {
            $storage->delete($column->image_file2);
        }
        if ($storage->exists($column->image_file3)) {
            $storage->delete($column->image_file3);
        }
        if ($storage->exists($column->image_file4)) {
            $storage->delete($column->image_file4);
        }
        if ($storage->exists($column->image_file5)) {
            $storage->delete($column->image_file5);
        }
        if ($storage->exists($column->image_file6)) {
            $storage->delete($column->image_file6);
        }

        $column->delete();

        return response()->json([
            'next' => route('painter.column_list')
        ]);

    }
}
