<?php

namespace App\Http\Controllers\Api\V1\Painter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Http\Request;
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
        $threads = $painter->chatThreads()->with(['chatMessages', 'user', 'painter'])->orderBy('updated_at', 'desc')->get();

        $threads->map->setAppends(ChatThread::$appendValues);

        return response()->json($threads->toArray());
    }
}
