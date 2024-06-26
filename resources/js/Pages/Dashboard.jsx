import ChatLayout from '@/Layouts/ChatLayout';
import { Head } from '@inertiajs/react';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import {useEffect, useRef, useState} from "react";
import {ChatBubbleLeftRightIcon} from "@heroicons/react/24/solid/index.js";
import ConversationHeader from "@/Components/App/ConversationHeader.jsx";
import MessageItem from "@/Components/App/MessageItem.jsx";
import MessageInput from "@/Components/App/MessageInput.jsx";

function Dashboard({ selectedConversation = null, messages = null  }) {
// console.log('messages.....', messages);
// console.log('selectedConversation.....', selectedConversation);
    const [localMessages, setLocalMessages] = useState([]);
    const messagesContainerReference=  useRef(null);

    useEffect(() => {
        setLocalMessages(messages ? messages.data.reverse() : []);
    }, [messages]);

    return (
        <>
            <Head title="Dashbaord" />

            {!messages && (
                <div className={"flex flex-col gap-3 justify-center items-center text-center h-full opacity-35"}>
                    <div className={"text-2xl md:text-4xl p-16 text-slate-200"}>
                        Please select conversation to see messages
                    </div>
                    <ChatBubbleLeftRightIcon className={"w-32 h-32 inline-block"} />
                </div>
            )}

            {messages && (
                <>
                    <ConversationHeader selectedConversation={selectedConversation} />
                    <div ref={messagesContainerReference} className={"flex-1 overflow-y-auto p-5"}>
                        {localMessages.length === 0 && (
                            <div className={"flex justify-center items-center h-full"}>
                                <div className={"text-lg text-slate-200"}>
                                    No messages found
                                </div>
                            </div>
                        )}

                        {localMessages.length > 0 && (
                            <div className={"flex-1 flex flex-col"}>
                                {localMessages.map((message) => (
                                    <MessageItem
                                        key={message.id}
                                        message={message}
                                    />
                                ))}
                            </div>
                        )}
                    </div>
                    {/*<MessageInput conversation={selectedConversation} />*/}
                </>
            )}

        </>
    );
}

Dashboard.layout = (page) => {
    return (
        <AuthenticatedLayout user={page.props.auth.user}>
             <ChatLayout children={page} />
        </AuthenticatedLayout>
    )
}

export  default Dashboard;
