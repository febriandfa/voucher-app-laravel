import DataTables from '@/components/data-tables';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { BreadcrumbItem, Recipient } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/react';
import { Pen, Trash } from 'lucide-react';

export default function IndexRecipient() {
    const { recipients } = usePage().props as {
        recipients?: Recipient[];
    };

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Penerima Voucher',
            href: route('recipient.index'),
        },
    ];

    const onDelete = (id: number) => {
        router.delete(route('recipient.destroy', id), {
            preserveScroll: true,
        });
    };

    const columns = [
        {
            name: 'No',
            selector: (row: Recipient) => row.index,
            sortable: true,
            width: '6rem',
        },
        {
            name: 'Nama Penerima',
            selector: (row: Recipient) => row.nama,
            sortable: true,
            wrap: true,
        },
        {
            name: 'Email Penerima',
            selector: (row: Recipient) => row.email,
            sortable: true,
            wrap: true,
        },
        {
            name: 'No WhatsApp',
            selector: (row: Recipient) => row.no_wa,
            sortable: true,
            wrap: true,
        },
        {
            name: 'Aksi',
            cell: (row: Recipient) => (
                <div className="space-x-1">
                    <Link href={route('recipient.edit', row.id)}>
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

    const data = (recipients ?? []).map((recipient, index) => ({
        index: index + 1,
        id: recipient.id,
        nama: recipient.nama,
        email: recipient.email,
        no_wa: recipient.no_wa,
    }));

    const searchBy = ['nama', 'email', 'no_wa'];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Penerima Voucher" />
            <div className="mb-4 flex gap-4">
                <Link href={route('recipient.create')} className="inline-block">
                    <Button>Tambah</Button>
                </Link>
                <Button>Bagikan Acak</Button>
                <Button>Bagikan Semua</Button>
            </div>
            <DataTables columns={columns} data={data ?? []} searchBy={searchBy} />
        </AppLayout>
    );
}
