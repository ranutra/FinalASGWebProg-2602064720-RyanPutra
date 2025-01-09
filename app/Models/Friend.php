<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Friend extends Model
{
    protected $table = "friends";
    protected $guarded = [];

    public function sender() : BelongsTo {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver() : BelongsTo {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
