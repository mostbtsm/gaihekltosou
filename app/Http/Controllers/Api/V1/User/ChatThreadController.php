<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Http\Request;
use App\Http\Requests\ChatThreadRequest;
use App\ChatThread;
use App\ChatMessage;

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
        $user = $this->guard()->user();
        $threads = $user->chatThreads()->with(['chatMessages', 'user', 'painter'])->orderBy('updated_at', 'desc')->get();

        $threads->map->setAppends(ChatThread::$appendValues);

        return response()->json($threads->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ChatThreadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChatThreadRequest $request)
    {
        $user = $this->guard()->user();

        $thread = new ChatThread();
        $thread->user_id = $user->id;
        $thread->painter_id = $request->painter_id;
        $thread->save();

        $message = new ChatMessage();
        $message->contents = $request->message;
        $message->message_key = $user->message_key;

        $thread->chatMessages()->save($message);

        return response()->json([
            'next' => route('user.chat.show', ['id' => $thread->id]),
        ]);
    }
}
