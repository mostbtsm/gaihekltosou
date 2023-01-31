<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\UserEntryRequest;
use App\Http\Requests\UserEditRequest;
use App\User;
use Image;
use App\Http\Middleware\ImageFilter;
use Storage;
use App\Painter;
use App\Example;
use App\Contract;
use App\Evaluation;
use App\Image as ImageTable;
use App\Favorite;
use Mail;
use App\Mail\Contact;
use App\Column;
use App\Attachment;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:user')->except(['entry', 'login']);
    }

    /**
     * Get the guard.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('user');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request\UserEntryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function entry(UserEntryRequest $request)
    {
        $user = new User();

        $user->email = $request->email;
        $user->password = $request->password;
        $user->name1 = $request->name1;
        $user->name2 = $request->name2;
        $user->message_key = md5(uniqid(rand(), true));  // チャットメッセージの発信元を特定するキー

        $user->save();

        return response()->json([
            'next' => route('user.complete')
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

        if ($this->guard()->attempt($credentials)) {
            return response()->json([
                'next' => route('user.mypage')
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
        $user = User::find($this->guard()->id());

        return response()->json($user->setAppends(['profile_image'])->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request\UserEditRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UserEditRequest $request)
    {
        $user = User::find($this->guard()->id());

        $user->name1 = $request->name1;
        $user->name2 = $request->name2;
        $user->kana1 = $request->kana1;
        $user->kana2 = $request->kana2;
        $user->nickname = $request->nickname;
        $user->postal = $request->postal;
        $user->prefectures = $request->prefectures;
        $user->city = $request->city;
        $user->address1 = $request->address1;
        $user->address2 = $request->address2;
        $user->tel = $request->tel;
        $user->mobile = $request->mobile;
        $user->birth_date = $request->birth_date;
        $user->gender = $request->gender;

        $user->save();

        return response()->json([
            'next' => route('user.mypage')
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

        $user = User::find($this->guard()->id());
        $storage = Storage::disk('profile_u');

        // リサイズ画像を保存
        $filename = md5(uniqid(rand(), true)) . '.jpg';
        $file = $request->image_file;
        $image = Image::make($file)->filter(new ImageFilter());

        if ($storage->put($filename, $image)) {
            // 新しい画像がアップロードされた場合、登録済みの画像ファイルがあれば削除する
            if ($storage->exists($user->image_file)) {
                $storage->delete($user->image_file);
            }

            $user->image_file = $filename;
            $user->save();
        }

        return response()->json([
            'profile_image' => $user->profile_image,
        ]);
    }

    /**
     * プロフィール画像削除
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteImage()
    {
        $user = User::find($this->guard()->id());

        $storage = Storage::disk('profile_u');
        if ($storage->exists($user->image_file)) {
            $storage->delete($user->image_file);
            $user->image_file = null;
            $user->save();
        }

        return response()->json([
            'profile_image' => config('const.no_image'),
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function properties()
    {
        $user = User::find($this->guard()->id());

        $properties = $user->properties()->get()->map(function($property) {
            return $property->setAppends(['image1', 'image2', 'image3', 'image4', 'image5', 'image6']);
        });

        return response()->json($properties->toArray());
    }

    /**
     * 業者検索
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {

        // ランクが1以上（管理者により認証済み）の業者会員を対象とする
        $painter = Painter::where('rank', '>=', 1);

        if ($request->filled('prefectures')) {
            // 都道府県で検索
            $painter = $painter->where('prefectures', $request->prefectures);
        }

        if ($request->filled('city')) {
            // 市町村で検索
            $keyword1 = '%' . mb_convert_kana($request->city, 'aCKV') . '%';
            $keyword2 = '%' . $request->city . '%';

            $painter = $painter->where(function($q) use ($keyword1, $keyword2) {
                $q->where('city', 'like', $keyword1)
                  ->orWhere('city', 'like', $keyword2);
            });
        }

        if ($request->filled('address')) {
            // 住所で検索
            $keyword1 = '%' . mb_convert_kana($request->address, 'aCKV') . '%';
            $keyword2 = '%' . $request->address . '%';

            $painter = $painter->where(function($q) use ($keyword1, $keyword2) {
                $q->where('address1', 'like', $keyword1)
                  ->orWhere('address1', 'like', $keyword2)
                  ->orWhere('address2', 'like', $keyword1)
                  ->orWhere('address2', 'like', $keyword2);
            });
        }

        if ($request->filled('name')) {
            // 事業所名・フリガナで検索
            $keyword1 = '%' . mb_convert_kana($request->name, 'aCKV') . '%';
            $keyword2 = '%' . $request->name . '%';

            $painter = $painter->where(function($q) use ($keyword1, $keyword2) {
                $q->where('name', 'like', $keyword1)
                  ->orWhere('name', 'like', $keyword2)
                  ->orWhere('kana', 'like', $keyword1)
                  ->orWhere('kana', 'like', $keyword2);
            });
        }

        if ($request->filled('category')) {
            // 業務内容カテゴリーで検索
            $painter = $painter->where('category', $request->category);
        }

        // お気に入り登録確認
        $painter = $painter->leftJoin('favorites', function ($join) {
            $join->on('favorites.painter_id', '=', 'painters.id')
              ->where('favorites.user_id', '=', $this->guard()->id())
              ->whereNull('favorites.deleted_at');
            })->select('painters.*','favorites.user_id');
        // １回あたりの表示件数
        $limit = $request->input('limit', 20);
        // 取得位置
        $skip = $request->input('skip', 0);

        // ランクの高い順に取得する
        // TODO:将来的には並べ替え対象を引数で受け取る
        $painter = $painter->orderby('rank', 'desc')->orderby('id', 'asc');

        // 表示件数分取得
        $painter = $painter->skip($skip)->limit($limit);

        // return $painter;
//        return $painter->get();
        $array = $painter->get();
        $array_length = count($array);

        $storage = Storage::disk('profile_p');

        for ($i = 0; $i < $array_length; $i++) {
          if ($storage->exists($array[$i]->image_file)) {
            $array[$i]->image_file = $storage->url($array[$i]->image_file);
          }
          // 評価件数
          $evaluation = Evaluation::where('painter_id', $array[$i]->id);
          // 評価済のみ検索
          $evaluation = $evaluation->where('flg', '1');
          $array[$i]->eva_count = $evaluation->count();

          // コラム件数
          $column = Column::where('painter_id', $array[$i]->id);
          // 公開データのみ検索
          $column = $column->where('public', '1');
          $array[$i]->col_count = $column->count();
        }
        // return $column;
        return $array;
    }

    /**
     * 施工事例データ取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function examplelist(Request $request)
    {
        // 公開承諾済データのみ取得
        $example = Example::where('public_consent', 1);

        if ($request->has('painter_id')) {
            $painter_id = $request->painter_id;

            // 業者IDが指定されていれば、指定の業者のデータのみ取得
            if (is_array($painter_id)) {
                $example = $example->whereIn('examples.painter_id', $painter_id);
            } else {
                $example = $example->where('examples.painter_id', $painter_id);
            }
        }

        // 契約、業者JOIN
        $example = $example->join('painters', 'examples.painter_id', '=', 'painters.id')
            ->join('contracts', 'examples.contract_id', '=', 'contracts.id')
            ->join('properties', 'contracts.property_id', '=', 'properties.id')
            ->select('examples.*','painters.name','properties.name as pname','properties.type','properties.address','contracts.category','contracts.period','contracts.warranty');

        // １回あたりの表示件数
        $limit = $request->input('limit', 20);
        // 取得位置
        $skip = $request->input('skip', 0);

        // 最新のデータから順に取得
        $example = $example->orderby('examples.updated_at', 'desc');

        // 表示件数分取得
        // 業者指定ならばすべて取得
        if ($request->has('painter_id')) {
        } else {
          $example = $example->skip($skip)->limit($limit);
        }
//        $example = $example->skip($skip)->limit($limit);

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
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function evaluationupdate(Request $request)
    {
        $evaluation = Evaluation::find($request->id);

        $evaluation->quality = $request->quality;
        $evaluation->price = $request->price;
        $evaluation->speed = $request->speed;
        $evaluation->correspondence = $request->correspondence;
        $evaluation->evaluation = $request->evaluation;
        $evaluation->flg = 1;
        $evaluation->user_name = $request->name;

        $evaluation->save();

        // return Evaluation::where('user_id', $request->user_id)->get();
        // return redirect()->route('user.mypage');
        return response()->json([
            'next' => route('user.mypage')
        ]);
    }

    /**
     * 業者プロフィール画像取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function painterprofileimage(Request $request)
    {
        $pid = $request->input('id', '0');
        $painter = Painter::find($pid);

        return response()->json([
            'profile_image' => $painter->profile_image,
        ]);
    }

    /**
     * 業者画像取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function painterimages(Request $request)
    {
        $pid = $request->input('id', '0');
        $painter = Painter::find($pid);

        $attachment = $painter->loadAttachments()->attachments->sortBy('id');
        $attachment->map(function($item) {
            $item->setAppends(['url']);
        });

        return $attachment->pluck('url');
    }

    /**
     * 業者画像URL取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function painterimageurl(Request $request)
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
     * 施工事例画像URL取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function exampleimageurl(Request $request)
    {
        $storage = Storage::disk('example');

        $ret1 = '';
        $ret2 = '';
        $ret3 = '';
        $ret4 = '';
        $ret5 = '';
        $ret6 = '';

        $image_file1 = $request->input('image_file1', '');
        if ($storage->exists($image_file1)) {
          $ret1 = $storage->url($image_file1);
        }

        $image_file2 = $request->input('image_file2', '');
        if ($storage->exists($image_file2)) {
          $ret2 = $storage->url($image_file2);
        }

        $image_file3 = $request->input('image_file3', '');
        if ($storage->exists($image_file3)) {
          $ret3 = $storage->url($image_file3);
        }

        $image_file4 = $request->input('image_file4', '');
        if ($storage->exists($image_file4)) {
          $ret4 = $storage->url($image_file4);
        }

        $image_file5 = $request->input('image_file5', '');
        if ($storage->exists($image_file5)) {
          $ret5 = $storage->url($image_file5);
        }

        $image_file6 = $request->input('image_file6', '');
        if ($storage->exists($image_file6)) {
          $ret6 = $storage->url($image_file6);
        }

        return response()->json([
            'image_file1' => $ret1,
            'image_file2' => $ret2,
            'image_file3' => $ret3,
            'image_file4' => $ret4,
            'image_file5' => $ret5,
            'image_file6' => $ret6,
        ]);
    }

    /**
     * 口コミ取得
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getevaluation(Request $request)
    {
        // １回あたりの表示件数
        $limit = $request->input('limit', 0);
        $painter_id = $request->painter_id;

        $evaluation = Evaluation::where('painter_id', $painter_id);
        // 評価済のみ検索
        $evaluation = $evaluation->where('flg', '1');

        // 最新のデータから順に取得
        $evaluation = $evaluation->orderby('evaluations.updated_at', 'desc');

        // 表示件数分取得 指定なければすべて
        if ($limit > 0) {
            $evaluation = $evaluation->limit($limit);
        }

        // return $evaluation;
        return $evaluation->get();

    }

    /**
     * 口コミ別件数取得
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getevaluationcount(Request $request)
    {
        $ret1 = 0;
        $ret2 = 0;
        $ret3 = 0;
        $ret4 = 0;
        $ret5 = 0;

        $painter_id = $request->painter_id;

        $evaluation = Evaluation::where('painter_id', $painter_id);
        // 評価済のみ検索
        $evaluation = $evaluation->where('flg', '1');
        // 評価別検索
        $evaluation = $evaluation->where('correspondence', '1');
        $ret1 = $evaluation->count();

        $evaluation = Evaluation::where('painter_id', $painter_id);
        // 評価済のみ検索
        $evaluation = $evaluation->where('flg', '1');
        // 評価別検索
        $evaluation = $evaluation->where('correspondence', '2');
        $ret2 = $evaluation->count();

        $evaluation = Evaluation::where('painter_id', $painter_id);
        // 評価済のみ検索
        $evaluation = $evaluation->where('flg', '1');
        // 評価別検索
        $evaluation = $evaluation->where('correspondence', '3');
        $ret3 = $evaluation->count();

        $evaluation = Evaluation::where('painter_id', $painter_id);
        // 評価済のみ検索
        $evaluation = $evaluation->where('flg', '1');
        // 評価別検索
        $evaluation = $evaluation->where('correspondence', '4');
        $ret4 = $evaluation->count();

        $evaluation = Evaluation::where('painter_id', $painter_id);
        // 評価済のみ検索
        $evaluation = $evaluation->where('flg', '1');
        // 評価別検索
        $evaluation = $evaluation->where('correspondence', '5');
        $ret5 = $evaluation->count();

        return response()->json([
            'count1' => $ret1,
            'count2' => $ret2,
            'count3' => $ret3,
            'count4' => $ret4,
            'count5' => $ret5,
        ]);

    }

    /**
     * お気に入り業者検索
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function favorite(Request $request)
    {
        // ランクが1以上（管理者により認証済み）の業者会員を対象とする
        $painter = Painter::where('rank', '>=', 1);

        $favorite = Favorite::where('user_id', $this->guard()->id());;

        // お気に入り登録済の企業を検索
        $painter = $painter->whereIn('painters.id', $favorite->select('painter_id')->get());

        // お気に入り登録確認
        $painter = $painter->leftJoin('favorites', function ($join) {
                                            $join->on('favorites.painter_id', '=', 'painters.id')
                                              ->where('favorites.user_id', '=', $this->guard()->id())
                                              ->whereNull('favorites.deleted_at');
                                            })->select('painters.*','favorites.user_id');

        // １回あたりの表示件数
        $limit = $request->input('limit', 20);
        // 取得位置
        $skip = $request->input('skip', 0);

        // ランクの高い順に取得する
        // TODO:将来的には並べ替え対象を引数で受け取る
        $painter = $painter->orderby('rank', 'desc')->orderby('id', 'asc');

        // 表示件数分取得
        $painter = $painter->skip($skip)->limit($limit);

        // return $painter;
//        return $painter->get();
        $array = $painter->get();
        $array_length = count($array);

        $storage = Storage::disk('profile_p');

        for ($i = 0; $i < $array_length; $i++) {
          if ($storage->exists($array[$i]->image_file)) {
            $array[$i]->image_file = $storage->url($array[$i]->image_file);
          }
          // 評価件数
          $evaluation = Evaluation::where('painter_id', $array[$i]->id);
          // 評価済のみ検索
          $evaluation = $evaluation->where('flg', '1');
          $array[$i]->eva_count = $evaluation->count();

          // コラム件数
          $column = Column::where('painter_id', $array[$i]->id);
          // 公開データのみ検索
          $column = $column->where('public', '1');
          $array[$i]->col_count = $column->count();
        }

        // return $column;
        return $array;

    }

    /**
     * お気に入り登録
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addfavorite(Request $request)
    {
        $favorite = new Favorite();

        $favorite->user_id = $this->guard()->id();
        $favorite->painter_id = $request->painter_id;

        $favorite->save();

        return response()->json();

    }

    /**
     * お気に入り解除
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deletefavorite(Request $request)
    {
        $favorite = Favorite::where('user_id', $this->guard()->id());
        $favorite = $favorite->where('painter_id', $request->painter_id);

        $favorite->delete();

        return response()->json();

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
            $user = $this->guard()->user();

            $name = $user->full_name;
            $email = $user->email;
            $contents = $request->input('contents');
            $userType = '個人';

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
            'old_password' => 'required|password:user',
            'new_password' => 'required|string|min:8|max:256|alpha_dash|confirmed',
        ]);

        $user = $this->guard()->user();
        $user->password = $request->input('new_password');
        $user->save();

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
            'password' => 'password:user',
        ]);

        if ($request->input('confirmed', false)) {
            User::destroy($this->guard()->id());
            $this->guard()->logout();
        }

        return response()->json([
            'next' => route('top'),
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
        $painter_id = $request->painter_id;

        $column = Column::where('painter_id', $painter_id);
        // 公開データのみ検索
        $column = $column->where('public', '1');

        // 最新のデータから順に取得
        $column = $column->orderby('columns.updated_at', 'desc');

        // 表示件数分取得 指定なければすべて
        if ($limit > 0) {
            $column = $column->limit($limit);
        }
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
}
