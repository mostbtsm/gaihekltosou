<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\Contact;
use Mail;

class InquiryController extends Controller
{
    /**
     * お問い合わせ（ログイン画面　個人・業者共通）
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // バリデーション
        $request->validate([
            'confirmed' => 'nullable|boolean',
            'name'      => 'required|string|max:256',
            'email'     => 'required|string|max:256',
            'contents'  => 'required|string|max:2048',
        ]);

        if ($request->input('confirmed', false)) {
            // メール送信処理
            $name = $request->input('name');
            $email = $request->input('email');
            $contents = $request->input('contents');
            $userType = ($request->input('userType') == 0 ? '個人' : ($request->input('userType') == 1 ? '企業' : '非会員'));

            $template = 'contact_admin';
            $subject = 'お問い合わせ送信通知';
            Mail::to(config('mailsending.contact.send_to_admin'))->send(new Contact($template, $userType, $subject, $email, $name, $contents));

            $template = 'contact_user';
            $subject = 'お問い合わせありがとうございます';
            Mail::to($email)->send(new Contact($template, $userType, $subject, $email, $name, $contents));
        }

        return response()->json();
    }
}