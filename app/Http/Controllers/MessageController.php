<?php

namespace App\Http\Controllers;

use App\Events\SocketMessage;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Models\Group;
use App\Models\Message;
use App\Models\MessageAttachment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    /** Load Messages by user */
    public function user(User $user)
    {
        $messages = Message::where('sender_id', Auth::id())
            ->where('receiver_id', $user->id)
            ->orWhere('sender_id', $user->id)
            ->where('receiver_id', Auth::id())
            ->latest()
            ->paginate(10);

        //dd($messages, MessageResource::collection($messages));

        return inertia('Dashboard',
            [
                'selectedConversation' => $user->toConversationArray(),
                'messages' => MessageResource::collection($messages),
            ]
        );

    }

    /** Load Messages by group */
     public function group(Group $group)
    {
        $messages = Message::where('group_id', $group->id)
            ->latest()
            ->paginate(10);

        return inertia('Dashboard',
            [
                'selectedConversation' => $group->toConversationArray(),
                'messages' => MessageResource::collection($messages),
            ]
        );
    }

    /** Load Older messages */
     public function older(Message $message)
    {
        if($message->group_id){

            $messages = Message::where('created_at', '<', $message->created_at)
                ->where('group_id', $message->group_id)
                ->latest()
                ->paginate(10);
        }else{

            $messages = Message::where('created_at', '<', $message->created_at)
                ->where( function ($query) use ($message){
                    $query->where('sender_id', $message->sender_id)
                        ->orWhere('receiver_id', $message->receiver_id)
                        ->orWhere('sender_id', $message->receiver_id)
                        ->where('receiver_id', $message->sender_id);
                })
                ->latest()
                ->paginate(10);
        }

        return MessageResource::collection($messages);
    }

     /** Load Store messages */
     public function store(StoreMessageRequest $request)
    {
        $data = $request->validated();
        $data['sender_id'] = Auth::id();
        $receiverId = $data['receiver_id'] ?? null;
        $groupId = $data['group_id'] ?? null;

        $files = $data['files'] ?? [];

        $message = Message::create([$data]);

        $attachments = [];
        if ($files) {
            foreach ($files as $file) {
                $directory = 'attachments/' . Str::random(32);
                Storage::makeDirectory($directory);

                $model = [
                    'message_id' => $message->id,
                    'name' => $file->getClientOriginalName(),
                    'mime' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                    'path' => $file->store($directory, 'public'),
                ];

                $attachment = MessageAttachment::create($model);
                $attachments[] = $attachment;
            }
                 $message->attachments = $attachments;
        }

        if ($receiverId){
            Conversation::updateConversationWIthMessage($receiverId, Auth::id(), $message);
        }

        if ($groupId){
            Group::updateGroupWithConversation($groupId, $message);
        }

        SocketMessage::dispatch($message);

        return new MessageResource($message);

    }

     /** Load Delete messages */
     public function destroy(Message $message)
    {
        /** Checking if the user is the owner of the message before deleting */
        if ($message->sender_id !== Auth::id()){
            return response()->json(['message' => 'Forbidden'], 403);
        }else{
            $message->delete();
            return response('', 204);
        }
    }
}
