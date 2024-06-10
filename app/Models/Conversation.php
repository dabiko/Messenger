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
        })->concat($allGroups->map(function (Group $group) {
            return $group->toConversationArray();
        }));
    }

    public static function updateConversationWIthMessage($userId1, $userId2, $message): void
    {
        /** Find conversation by userId1 and userId2 and update the last message id */

        $conversation = Conversation::where(function ($query) use ($userId1, $userId2) {
            $query->where('user_id1', $userId1)
                ->where('user_id2', $userId2);
        })->orWhere(function ($query) use ($userId1, $userId2) {
            $query->where('user_id1', $userId2)
                ->where('user_id2', $userId1);
        })->first();

        if ($conversation) {
            $conversation->update([
                'last_message_id' => $message->id
            ]);
        }else{
            Conversation::create([
                'user_id1' => $userId1,
                'user_id2' => $userId2,
                'last_message_id' => $message->id
            ]);
        }

    }
}
