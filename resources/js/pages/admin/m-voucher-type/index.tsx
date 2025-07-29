import DataTables from '@/components/data-tables';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { BreadcrumbItem, MVoucherType } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/react';
import { Pen, Trash } from 'lucide-react';

export default function IndexVoucherType() {
    const { mVoucherTypes } = usePage().props as {
        mVoucherTypes?: MVoucherType[];
    };

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Tipe Voucher',
            href: route('m-voucher-type.index'),
        },
    ];

    const onDelete = (id: number) => {
        router.delete(route('m-voucher-type.destroy', id), {
            preserveScroll: true,
        });
    };

    const columns = [
        {
            name: 'No',
            selector: (row: MVoucherType) => row.index,
            sortable: true,
            width: '6rem',
        },
        {
            name: 'Nama Tipe Voucher',
            selector: (row: MVoucherType) => row.nama,
            sortable: true,
            wrap: true,
        },
        {
            name: 'Aksi',
            cell: (row: MVoucherType) => (
                <div className="space-x-1">
                    <Link href={route('m-voucher-type.edit', row.id)}>
                        <Button size="icon" variant="default">
                            <Pen />
                        </Button>
                    </Link>
                    <Button size="icon" variant="destructive" onClick={() => onDelete(row.id)}>
                        <Trash />
                    </Button>
                </div>
            ),
            width: '11rem',
        },
    ];

    const data = (mVoucherTypes ?? []).map((mVoucherType, index) => ({
        index: index + 1,
        id: mVoucherType.id,
        nama: mVoucherType.nama,
        created_at: mVoucherType.created_at,
        updated_at: mVoucherType.updated_at,
    }));

    const searchBy = ['nama', 'created_at', 'updated_at'];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Tipe Voucher" />
            <Link href={route('m-voucher-type.create')} className="mb-4 inline-block">
                <Button>Tambah</Button>
            </Link>
            <DataTables columns={columns} data={data ?? []} searchBy={searchBy} />
        </AppLayout>
    );
}
