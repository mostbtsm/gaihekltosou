<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\NoticeRequest;
use App\Notice;
use App\Painter;
use App\User;
use App\Mail\NoticeMail;

class NoticeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Notice::withTrashed()->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(config('const.template.notice.create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\NoticeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoticeRequest $request)
    {
        $notice = new Notice();

        $notice->type = $request->type;
        $notice->subject = $request->subject;
        $notice->contents = $request->contents;
        $notice->send_flg = 0;

        $notice->save();

        return redirect('/admin/notice_list');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view(config('const.template.notice.show'), ['notice' => Notice::withTrashed()->find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view(config('const.template.notice.edit'), ['notice' => Notice::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\NoticeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NoticeRequest $request, $id)
    {
        $notice = Notice::find($id);

        $notice->type = $request->type;
        $notice->subject = $request->subject;
        $notice->contents = $request->contents;

        $notice->save();

        return redirect('/admin/notice_list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Notice::destroy($id);

        return Notice::withTrashed()->get();
    }

    /**
     * お知らせをメールで送信する
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        $bcc = [];

        if ($request->type == 0) {
            // 共通
            $users = User::select('email')->get();
            $painters = Painter::select('email')->get();

            foreach ($users as $user) {
                $bcc[] = $user->email;
            }

            foreach ($painters as $painter) {
                $bcc[] = $painter->email;
            }
        } else if ($request->type == 1) {
            // 個人
            $users = User::select('email')->get();

            foreach ($users as $user) {
                $bcc[] = $user->email;
            }
        } else {
            // 業者
            $painters = Painter::select('email')->get();

            foreach ($painters as $painter) {
                $bcc[] = $painter->email;
            }
        }

        // メール送信パラメータ作成
        $data = [];

        $data['subject'] = $request->subject;
        $data['contents'] = $request->contents;

        Mail::to(config('mailsending.notice.send_from'))->bcc($bcc)->send(new NoticeMail($data));

        $notice = Notice::find($request->id);

        $notice->send_flg = 1;

        $notice->save();
    }
}
