<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\PusherBroadcast;

class PusherController extends Controller
{
    public function openChat()
    {
        return view('pages.messages');
    }   

    public function broadcast(Request $request)
    {
        broadcast(new PusherBroadcast($request->get('message')))->toOthers();
        // This is a method provided by Laravel for broadcasting events. It allows you to send events to various broadcasting drivers, and in this case, it's using Pusher.

        return view('broadcast', ['message' => $request->get('message')]);
    }

    public function receive(Request $request)
    {
        $message = $request->input('message');

        return view('receive', ['message' => $request->get('message')]);

    }
}
