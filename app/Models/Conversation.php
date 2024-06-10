<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public static function getConversationsForSidebar(User $user)
    {
        $allUsers = User::getUsersExceptAuthUser($user);
        $allGroups = Group::getGroupsExceptAuthUser($user);
        return $allUsers->map(function (User $user) {
            return $user->toConversationArray();
        })->concat((array)$allGroups->map(function (Group $group) {
            return $group->toConversationArray();
        }));
    }
}
