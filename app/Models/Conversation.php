<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id1',
        'user_id2',
        'last_message_id'
    ];

     public function lastMessage(): belongsTo
    {
        return $this->belongsTo(Message::class, 'last_message_id');
    }

    public function user1(): belongsTo
    {
        return $this->belongsTo(User::class, 'user_id1');
    }

    public function user2(): belongsTo
    {
        return $this->belongsTo(User::class, 'user_id2');
    }
}
