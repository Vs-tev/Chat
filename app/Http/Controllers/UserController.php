<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Message;

use Illuminate\Database\Query\JoinClause;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Builder;

class UserController extends Controller
{
    public function index(Request $request){

        //We select all users and join conversation (with model not possible because conversations table has two user_id columns -> 'user_one' and 'user_two')
        //Then we join message to conversation and output the last message from the conversation
        
        $user = \App\Models\User::select('users.*', 'conversations.id as conversation_id', 'conversations.user_one', 'conversations.user_two', 'messages.message as last_message' , 'messages.created_at as last_message_date',
        DB::raw('COUNT(CASE WHEN conversation_id = conversations.id and is_seen = 0 and user_id != '.auth()->id().' THEN 1 else NULL END) as message_count '))
        ->withCasts(['last_message_date' => 'datetime:d M H:i'])
        ->where([['users.id' , '<>' , auth()->id()], ['users.name', 'LIKE', '%'. $request->search_user_name. '%']])
        ->leftJoin('conversations', function($join){
            $join->on('users.id', '=', 'conversations.user_one')->where('conversations.user_two', auth()->id())
            ->orOn('users.id', '=','conversations.user_two')->where('conversations.user_one', auth()->id());
        })
        ->leftJoin('messages', function($join){
            $join->on('messages.conversation_id', '=', 'conversations.id')
            ->whereRaw('messages.id IN (select MAX(messages.id) from messages as messages join conversations as conversations on conversations.id = messages.conversation_id group by conversations.id)');
        })
        ->orderBy('messages.created_at', 'desc')
        ->groupBy('users.id' )
        ->get();

        return $user;
     
    }
}
