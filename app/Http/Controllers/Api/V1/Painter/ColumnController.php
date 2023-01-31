<?php

namespace App\Http\Controllers\Api\V1\Painter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Middleware\ImageFilter;
use App\Http\Requests\ColumnRequest;
use App\Column;
use App\Attachment;
use Storage;
use Image;

class ColumnController extends Controller
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
        $columns = $painter->columns()->with('attachments')->get();

        $columns->map(function($item) {
            $item->setAppends(Column::$appendValues);
        });

        return response()->json($columns->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request\ColumnRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ColumnRequest $request)
    {
        $painter = $this->guard()->user();
        $count = $painter->columns()->count();
        abort_if($count >= 3, 403); // TODO 最大登録数の定義場所を決める

        $column = new Column();

        $column->painter_id = $this->guard()->id();
        $column->title = $request->title;
        $column->contents = $request->contents;
        $column->public = Column::PUBLIC_ON;

        $column->save();

        $storage = Storage::disk('column');

        for ($i = 1; $i <= 4; $i++) {
            $field = 'image_file' . $i;
            $attachment = $column->loadAttachments()->attachments->where('index', $i)->first();

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
                        'storage'  => 'column',
                        'index'    => $i,
                    ]);

                    $attachment->save();
                    $column->attachments()->syncWithoutDetaching($attachment->id);
                }
            } elseif ($request->boolean('del_flg' . $i) && $attachment) {
                // 登録済みの画像ファイルがある場合、明示的に削除指定されていれば削除する
                $attachment->delete();
            }
        }

        return response()->json([
            'next' => route('painter.column')
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
        $column = $painter->columns()->where('id', $id)->first();
        abort_if(!$column, 403);

        return response()->json($column->setAppends(Column::$appendValues)->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request\ColumnRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ColumnRequest $request, $id)
    {
        $painter = $this->guard()->user();
        $column = $painter->columns()->where('id', $id)->first();
        abort_if(!$column, 403);

        $column->title = $request->title;
        $column->contents = $request->contents;
        $column->public = Column::PUBLIC_ON;

        $column->save();

        $storage = Storage::disk('column');

        for ($i = 1; $i <= 4; $i++) {
            $field = 'image_file' . $i;
            $attachment = $column->loadAttachments()->attachments->where('index', $i)->first();

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
                        'storage'  => 'column',
                        'index'    => $i,
                    ]);

                    $attachment->save();
                    $column->attachments()->syncWithoutDetaching($attachment->id);
                }
            } elseif ($request->boolean('del_flg' . $i) && $attachment) {
                // 登録済みの画像ファイルがある場合、明示的に削除指定されていれば削除する
                $attachment->delete();
            }
        }

        return response()->json([
            'next' => route('painter.column')
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
        $column = $painter->columns()->where('id', $id)->first();
        abort_if(!$column, 403);

        $column->delete();

        return response()->json([
            'next' => route('painter.column')
        ]);
    }
}
