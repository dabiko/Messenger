import {usePage} from "@inertiajs/react";
import UserAvatar from "@/Components/App/UserAvatar.jsx";


const MessageItem = ({ message, attachmentClick }) => {
    const currentUser = usePage();

    return (
        <div className={"chat " + (message.sender_id === currentUser.id ? "chat-end" : "chat-start") }>
            {<UserAvatar user={message.sender} />}
            <div className={"chat-header"}>

            </div>
        </div>
    );
}

export default MessageItem
