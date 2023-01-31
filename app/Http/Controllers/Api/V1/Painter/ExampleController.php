<?php

namespace App\Http\Controllers\Api\V1\Painter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Middleware\ImageFilter;
use App\Http\Requests\ExampleRequest;
use App\Example;
use App\Attachment;
use Storage;
use Image;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:painter');
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $painter = $this->guard()->user();
        $examples = $painter->examples()->with('attachments')->orderby('updated_at', 'desc')->get();

        $examples->map(function($item) {
            $item->setAppends(Example::$appendValues);
        });

        return response()->json($examples->toArray());
    }

    /**
     * 外部施工事例登録
     *
     * @param  \App\Http\Request\ExampleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExampleRequest $request)
    {
        $painter = $this->guard()->user();
        $count = $painter->examples()->count();
        abort_if($count >= 3, 403); // TODO 最大登録数の定義場所を決める

        $example = new Example();

        $example->painter_id = $this->guard()->id();
        $example->contract_id = 0;
        $example->title = $request->title;
        $example->address = $request->address;
        $example->property_type = $request->property_type;
        $example->amount = $request->amount;
        $example->period = $request->period;
        $example->comment = $request->comment;
        $example->public_consent = Example::PUBLIC_ON;

        $example->categories = $request->get('category', []);
        $example->complete_date_json = [
            'year'  => $request->complete_date_year,
            'month' => $request->complete_date_month,
        ];

        $warranties = [
            '外壁塗装'     => $request->warranty_value1,
            '屋根塗装'     => $request->warranty_value2,
            '屋上防水'     => $request->warranty_value3,
            'ベランダ防水' => $request->warranty_value4,
        ];

        if (strlen($request->warranty_name5)) {
            $warranties[$request->warranty_name5] = $request->warranty_value5;
        }

        $example->warranty_json = $warranties;
        $example->save();

        $storage = Storage::disk('example');

        for ($i = 1; $i <= 6; $i++) {
            $field = 'image_file' . $i;
            $attachment = $example->loadAttachments()->attachments->where('index', $i)->first();

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
                        'storage'  => 'example',
                        'index'    => $i,
                    ]);

                    $attachment->save();
                    $example->attachments()->syncWithoutDetaching($attachment->id);
                }
            } elseif ($request->boolean('del_flg' . $i) && $attachment) {
                // 登録済みの画像ファイルがある場合、明示的に削除指定されていれば削除する
                $attachment->delete();
            }
        }

        return response()->json([
            'next' => route('painter.example')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $painter = $this->guard()->user();
        $example = $painter->examples()->where('id', $id)->first();
        abort_if(!$example, 403);

        return response()->json($example->setAppends(Example::$appendValues)->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request\ExampleRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExampleRequest $request, $id)
    {
        $painter = $this->guard()->user();
        $example = $painter->examples()->where('id', $id)->first();
        abort_if(!$example, 403);

        $example->title = $request->title;
        $example->address = $request->address;
        $example->property_type = $request->property_type;
        $example->amount = $request->amount;
        $example->period = $request->period;
        $example->comment = $request->comment;
        $example->public_consent = Example::PUBLIC_ON;

        $example->categories = $request->get('category', []);
        $example->complete_date_json = [
            'year'  => $request->complete_date_year,
            'month' => $request->complete_date_month,
        ];

        $warranties = [
            '外壁塗装'     => $request->warranty_value1,
            '屋根塗装'     => $request->warranty_value2,
            '屋上防水'     => $request->warranty_value3,
            'ベランダ防水' => $request->warranty_value4,
        ];

        if (strlen($request->warranty_name5)) {
            $warranties[$request->warranty_name5] = $request->warranty_value5;
        }

        $example->warranty_json = $warranties;
        $example->save();

        $storage = Storage::disk('example');

        for ($i = 1; $i <= 6; $i++) {
            $field = 'image_file' . $i;
            $attachment = $example->loadAttachments()->attachments->where('index', $i)->first();

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
                        'storage'  => 'example',
                        'index'    => $i,
                    ]);

                    $attachment->save();
                    $example->attachments()->syncWithoutDetaching($attachment->id);
                }
            } elseif ($request->boolean('del_flg' . $i) && $attachment) {
                // 登録済みの画像ファイルがある場合、明示的に削除指定されていれば削除する
                $attachment->delete();
            }
        }

        return response()->json([
            'next' => route('painter.example')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $painter = $this->guard()->user();
        $example = $painter->examples()->where('id', $id)->first();
        abort_if(!$example, 403);

        $example->delete();

        return response()->json([
            'next' => route('painter.example')
        ]);
    }
}
