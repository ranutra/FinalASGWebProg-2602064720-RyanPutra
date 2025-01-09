<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model
{
    protected $table = "chats";
    protected $guarded = [];

    public function sender() : BelongsTo {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver() : BelongsTo {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
