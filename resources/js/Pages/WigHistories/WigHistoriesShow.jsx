import { usePage } from "@inertiajs/react"
import React from "react"

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';


export default function WigHistoriesIndex({ }) {

    const { auth } = usePage.props;
    return (
        <AuthenticatedLayout user={auth?.user}>

        </AuthenticatedLayout>
    )
}