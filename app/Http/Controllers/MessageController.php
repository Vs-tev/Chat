<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Events\NewChatMessage;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $conversation = Conversation::with('message.user:id,name,profile_photo_path,created_at')
        ->where([
        ['user_one', $id], ['user_two' , auth()->id()]
        ])
        ->orWhere([['user_two', $id], ['user_one' , auth()->id()]])
        ->first();

        $messages = $conversation->message ?? '';

        return $messages;
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $conversation =  Conversation::where([
            ['user_one', $request->user["id"]], ['user_two' , auth()->id()]
            ])
            ->orWhere([['user_two', $request->user["id"]], ['user_one' , auth()->id()]])
            ->firstOr(function() use($request){

                $newConversation = new Conversation;

                $newConversation->user_one = auth()->id();
                $newConversation->user_two = $request->user["id"];
                $newConversation->status = 0;
                $newConversation->save();

                return $newConversation;
            });

            $conversation->newMessage($request);

            broadcast(new NewChatMessage($conversation, auth()->user(), $request->all()))->toOthers();

            return $conversation;
    }

    public function messageIsRead(Request $request){

        $messages = Message::where([['conversation_id', $request->selected_user['conversation_id']],
        ['user_id', $request->selected_user['id']]])->update(['is_seen' => 1]);

        return $messages;
    }

}
