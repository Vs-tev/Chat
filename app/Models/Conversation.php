<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;


    public function message()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    public function newMessage($message){
        
       $this->message()->create([
            'message' => $message->message,
            'is_seen' => 0,
            'user_id' => auth()->id(),
            'conversation_id' => $this->id,
        ]);  
    }


}
