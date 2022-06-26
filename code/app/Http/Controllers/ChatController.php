<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\Chat;

class ChatController extends Controller
{
    public function store(Request $request)
    {

        $chat = new Chat;
        $chat->message = $request->message;
        $chat->mentor = empty($request->mentor) ? '0' : $request->mentor;
        $chat->mentee = empty($request->mentee) ? '0' : $request->mentee;

        $chat->save();


        return App::call('App\Http\Controllers\HomeController@afterandreturn' , ['request' => $request]);
    }
    
}
