<?php

namespace App\Http\Controllers\Web\Painter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ChatThread;
use App\Painter;

class ChatThreadController extends Controller
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
        return view(config('const.template.painter.chat'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $painter = $this->guard()->user();
        $thread = $painter->chatThreads()
            ->where('id', $id)
            ->first();

        abort_if(!$thread, 404);

        $user = $thread->user()->first();

        return view(config('const.template.painter.chat_detail'), compact('thread', 'user', 'painter'));
    }
}
