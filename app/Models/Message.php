<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Message extends Model
{
    use HasFactory;

       /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'message',
        'sender_id',
        'group_id',
        'receiver_id',
    ];

     public function sender(): belongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): belongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function group(): belongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function attachments(): hasMany
    {
        return $this->hasMany(MessageAttachment::class);
    }
}
