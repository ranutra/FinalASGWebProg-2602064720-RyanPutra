<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Avatar extends Model
{
    protected $table = "avatars";
    protected $guarded = [];

    public function buyer() : BelongsToMany {
        return $this->belongsToMany(User::class, 'avatar_transactions')->withTimestamps();
    }
}
