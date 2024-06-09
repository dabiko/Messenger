import { usePage } from '@inertiajs/react';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";

const ChatLayout = ({ children }) => {
    const page = usePage();
    const conversations = page.props.conversations;
    const selectedConversations = page.props.selectedConversations;

    console.log("conversations", conversations);
    console.log("selectedConversations", selectedConversations);

    return (
        <>
            <p className={"text-amber-50"}>ChatLayout</p>
            <div>
                { children }
            </div>
        </>
    );
}
export default ChatLayout;
