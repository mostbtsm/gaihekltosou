<?php

namespace App\Http\Controllers\Web\User;

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
        $this->middleware('auth:user');
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(config('const.template.user.chat'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $painter = Painter::where('rank', '>=', Painter::RANK_MEMBER)
            ->where('id', $id)
            ->first();

        abort_if(!$painter, 404);

        $thread = ChatThread::where([
            ['user_id', $this->guard()->id()],
            ['painter_id', $painter->id],
        ])->first();

        if ($thread) {
            return redirect()->route('user.chat.show', ['id' => $thread->id]);
        }

        return view(config('const.template.user.chat_create'), ['painter' => $painter]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->guard()->user();
        $thread = $user->chatThreads()
            ->where('id', $id)
            ->first();

        abort_if(!$thread, 404);

        $painter = $thread->painter()->first();

        return view(config('const.template.user.chat_detail'), compact('thread', 'user', 'painter'));
    }
}
