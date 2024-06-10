import { usePage } from '@inertiajs/react';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import {useEffect, useState} from "react";



const ChatLayout = ({ children }) => {
    const page = usePage();
    const conversations = page.props.conversations;
    const selectedConversations = page.props.selectedConversations;
    const [localConversations, setLocalConversations] = useState([]);
    const [sortedConversations, setSortedConversations] = useState([]);
    const [onlineUsers, setOnlineUsers] = useState({});

    const isUserOnline = (userId) => onlineUsers[userId];

    console.log("conversations", conversations);
    console.log("selectedConversations", selectedConversations);

    useEffect(() => {
        setSortedConversations(
            localConversations.sort((a, b) => {
                if (a.blocked_at && b.blocked_at){
                    return a.blocked_at > b.blocked_at ? 1 : -1;
                }else if (a.blocked_at){
                    return 1;
                }else if (b.blocked_at){
                    return -1;
                }

                if (a.last_message_date && b.last_message_date){
                    return b.last_message_date.localeCompare(a.last_message_date);
                }else if (a.last_message_date){
                    return -1;
                }else if (b.last_message_date){
                    return 1;
                }else{
                    return 0;
                }
            })

        );
    }, [localConversations]);

    useEffect(() => {
        setLocalConversations(conversations)
    }, [conversations]);

    useEffect(() => {
        Echo.join('online')
            .here((users) => {
                const onlineUserObj = Object.fromEntries(
                    users.map((user) => [user.id, user])
                );

                setOnlineUsers((prevOnlineUsers) => {
                    return { ...prevOnlineUsers, ...onlineUserObj };
                })
                // console.log("here", users);
            })
            .joining((user) => {
                setOnlineUsers((prevOnlineUsers) => {
                    const updatedUsers = { ...prevOnlineUsers };
                    updatedUsers[user.id] = user;
                    return updatedUsers;
                });
                // console.log("Joining", user);
            })
           .leaving((user) => {
               setOnlineUsers((prevOnlineUsers) => {
                    const updatedUsers = { ...prevOnlineUsers };
                    delete updatedUsers[user.id];
                    return updatedUsers;
                });
                // console.log("Leaving", user);
            })
           .error((error) => {
                console.log("error", error);
            })
        return () => {
            Echo.leave('online')
        }
    }, []);

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
