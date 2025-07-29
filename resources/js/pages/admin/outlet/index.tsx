import DataTables from '@/components/data-tables';
import AppLayout from '@/layouts/app-layout';
import { BreadcrumbItem, Outlet } from '@/types';
import { Head, usePage } from '@inertiajs/react';

export default function IndexVoucherType() {
    const { outlets } = usePage().props as {
        outlets?: Outlet[];
    };

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Outlet',
            href: route('outlet.index'),
        },
    ];

    const columns = [
        {
            name: 'No',
            selector: (row: Outlet) => row.index,
            sortable: true,
            width: '6rem',
        },
        {
            name: 'Nama Outlet',
            selector: (row: Outlet) => row.nama,
            sortable: true,
            wrap: true,
        },
        {
            name: 'Nama Admin Outlet',
            selector: (row: Outlet) => row.outlet_admin,
            sortable: true,
            wrap: true,
        },
    ];

    const data = (outlets ?? []).map((outlet, index) => ({
        index: index + 1,
        id: outlet.id,
        nama: outlet.nama,
        outlet_admin: outlet.user ? outlet.user.name : 'Tidak ada admin',
        created_at: outlet.created_at,
        updated_at: outlet.updated_at,
    }));

    const searchBy = ['nama', 'created_at', 'updated_at'];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Outlet" />
            <DataTables columns={columns} data={data ?? []} searchBy={searchBy} />
        </AppLayout>
    );
}
