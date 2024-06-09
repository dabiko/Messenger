import ChatLayout from '@/Layouts/ChatLayout';
import { Head } from '@inertiajs/react';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";

function Dashboard({ auth }) {
    return (
        <>
            <Head title="Dashbaord" />
            <p className={"text-amber-50"}>Messages</p>
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
