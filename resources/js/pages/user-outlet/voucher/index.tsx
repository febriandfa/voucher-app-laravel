import DataTables from '@/components/data-tables';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { BreadcrumbItem, Voucher } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/react';
import { Pen, Trash } from 'lucide-react';

export default function IndexVoucherType() {
    const { vouchers } = usePage().props as {
        vouchers?: Voucher[];
    };

    console.log(vouchers);

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Voucher',
            href: route('voucher.index'),
        },
    ];

    const onDelete = (id: number) => {
        router.delete(route('voucher.destroy', id), {
            preserveScroll: true,
        });
    };

    const columns = [
        {
            name: 'No',
            selector: (row: Voucher) => row.index,
            sortable: true,
            width: '6rem',
        },
        {
            name: 'Tipe Voucher',
            selector: (row: Voucher) => row.m_voucher_type,
            sortable: true,
            wrap: true,
        },
        {
            name: 'Deskripsi',
            selector: (row: Voucher) => row.deskripsi,
            sortable: true,
            wrap: true,
        },
        {
            name: 'Tanggal Terbit',
            selector: (row: Voucher) => row.tanggal_terbit,
            sortable: true,
            wrap: true,
        },
        {
            name: 'Tanggal Kadaluarsa',
            selector: (row: Voucher) => row.tanggal_kadaluarsa,
            sortable: true,
            wrap: true,
        },
        {
            name: 'Status',
            selector: (row: Voucher) => row.status,
            cell: (row: Voucher) => (
                <Badge variant={row.status === 'active' ? 'default' : 'destructive'} className="capitalize">
                    {row.status === 'active' ? 'Aktif' : 'Tidak Aktif'}
                </Badge>
            ),
            sortable: true,
            wrap: true,
        },
        {
            name: 'Aksi',
            cell: (row: Voucher) => (
                <div className="space-x-1">
                    <Link href={route('voucher.edit', row.id)}>
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

    const data = (vouchers ?? []).map((voucher, index) => ({
        index: index + 1,
        id: voucher.id,
        m_voucher_type: voucher.m_voucher_type.nama,
        deskripsi: voucher.deskripsi,
        tanggal_terbit: voucher.tanggal_terbit,
        tanggal_kadaluarsa: voucher.tanggal_kadaluarsa,
        status: voucher.status,
    }));

    const searchBy = ['voucher_type', 'tanggal_terbit', 'tanggal_kadaluarsa', 'status'];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Voucher" />
            <Link href={route('voucher.create')} className="mb-4 inline-block">
                <Button>Tambah</Button>
            </Link>
            <DataTables columns={columns} data={data ?? []} searchBy={searchBy} />
        </AppLayout>
    );
}
