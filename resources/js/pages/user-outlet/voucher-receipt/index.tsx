import DataTables from '@/components/data-tables';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { BreadcrumbItem, TransactionVoucherReceipt } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/react';
import { Trash } from 'lucide-react';

export default function IndexVoucherReceipt() {
    const { voucherReceipts } = usePage().props as {
        voucherReceipts?: TransactionVoucherReceipt[];
    };

    console.log('voucherReceipts', voucherReceipts);

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Transaksi Penerimaan Voucher',
            href: route('voucher-receipt.index'),
        },
    ];

    const onDelete = (id: number) => {
        router.delete(route('voucher-receipt.destroy', id), {
            preserveScroll: true,
        });
    };

    const columns = [
        {
            name: 'No',
            selector: (row: TransactionVoucherReceipt) => row.index,
            sortable: true,
            width: '6rem',
        },
        {
            name: 'Voucher',
            selector: (row: TransactionVoucherReceipt) => row.voucher,
            sortable: true,
            wrap: true,
        },
        {
            name: 'Nama Penerima',
            selector: (row: TransactionVoucherReceipt) => row.recipient,
            sortable: true,
            wrap: true,
        },
        {
            name: 'Tanggal Diterima',
            selector: (row: TransactionVoucherReceipt) => row.tanggal_penerimaan,
            sortable: true,
            wrap: true,
        },
        {
            name: 'Aksi',
            cell: (row: TransactionVoucherReceipt) => (
                <div className="space-x-1">
                    <Button size="icon" variant="destructive" onClick={() => onDelete(row.id)}>
                        <Trash />
                    </Button>
                </div>
            ),
            width: '11rem',
        },
    ];

    const data = (voucherReceipts ?? []).map((voucherReceipt, index) => ({
        index: index + 1,
        id: voucherReceipt.id,
        recipient: voucherReceipt.recipient.nama,
        voucher: `${voucherReceipt.voucher.m_voucher_type.nama} - ${voucherReceipt.voucher.deskripsi}`,
        tanggal_penerimaan: voucherReceipt.tanggal_penerimaan,
    }));

    const searchBy = ['recipient', 'voucher', 'tanggal_penerimaan'];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Transaksi Penerimaan Voucher" />
            <div className="mb-4 flex gap-4">
                <Link href={route('voucher-receipt.create')} className="inline-block">
                    <Button>Tambah</Button>
                </Link>
            </div>
            <DataTables columns={columns} data={data ?? []} searchBy={searchBy} />
        </AppLayout>
    );
}
