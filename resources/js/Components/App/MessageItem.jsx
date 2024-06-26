import {usePage} from "@inertiajs/react";
import UserAvatar from "@/Components/App/UserAvatar.jsx";
import ReactMarkDown from "react-markdown";
import React from "react";
import { formatMessageDateLong } from "@/Helpers.jsx";


const MessageItem = ({ message }) => {
    const currentUser = usePage().props.auth.user;

    return (
        <div className={"chat " + (message.sender_id === currentUser.id ? "chat-end" : "chat-start") }>
            {<UserAvatar user={message.sender} />}
            <div className={"chat-header"}>
                {message.sender_id !== currentUser.id ? message.sender.name : ""}
                <time className={"time-xs opacity-50 ml-2"}>
                    {formatMessageDateLong(message.created_at)}
                </time>
            </div>
            <div className={"chat-bubble relative " + (message.sender_id === currentUser.id ? "chat-bubble-info" : "")}>
                <div className={"chat-message"}>
                    <div className={"chat-message-content"}>
                        <ReactMarkDown>{message.message}</ReactMarkDown>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default MessageItem
