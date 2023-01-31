<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Http\Request;
use App\Http\Requests\ChatMessageRequest;
use App\Events\MessageSent;
use App\ChatThread;
use App\ChatMessage;

class ChatMessageController extends Controller
{
    /**
     * Get the guard.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        if (Auth::guard('user')->check()) {
            return Auth::guard('user');
        } elseif (Auth::guard('painter')->check()) {
            return Auth::guard('painter');
        }

        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $this->guard()->user();
        abort_if(!$user, 403);
        $thread = $user->chatThreads()->where('id', $request->thread_id)->first();
        abort_if(!$thread, 403);

        $query = $thread->chatMessages();

        if ($request->filled('message_id')) {
            $query->where('id', '>', $request->message_id);
        }

        $messages = $query->orderBy('id', 'asc')->get();

        $messages->map(function($message) use($user) {
            $message->setAppends(ChatMessage::$appendValues);
            $message->is_my_message = $message->message_key === $user->message_key;
        });

        if (Auth::guard('user')->check()) {
            $thread->user_read_at = Date::now();
        } elseif (Auth::guard('painter')->check()) {
            $thread->painter_read_at = Date::now();
        }

        $thread->save();

        return response()->json([
            'thread'   => $thread->setAppends(ChatThread::$appendValues)->toArray(),
            'messages' => $messages,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ChatMessageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChatMessageRequest $request)
    {
        $user = $this->guard()->user();
        abort_if(!$user, 403);
        $thread = $user->chatThreads()->where('id', $request->thread_id)->first();
        abort_if(!$thread, 403);

        $message = new ChatMessage();
        $message->contents = $request->message;
        $message->message_key = $user->message_key;

        $thread->chatMessages()->save($message);

        // ブロードキャスト送信イベント
        event(new MessageSent(md5($thread->id), $message->message_key));

        return response()->json();
    }
}
