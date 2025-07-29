import DataTables from '@/components/data-tables';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { BreadcrumbItem, TransactionVoucherUsage } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/react';
import { Trash } from 'lucide-react';

export default function IndexVoucherUsage() {
    const { voucherUsages } = usePage().props as {
        voucherUsages?: TransactionVoucherUsage[];
    };

    console.log('voucherUsages', voucherUsages);

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Transaksi Pemakaian Voucher',
            href: route('voucher-usage.index'),
        },
    ];

    const onDelete = (id: number) => {
        router.delete(route('voucher-usage.destroy', id), {
            preserveScroll: true,
        });
    };

    const columns = [
        {
            name: 'No',
            selector: (row: TransactionVoucherUsage) => row.index,
            sortable: true,
            width: '6rem',
        },
        {
            name: 'Voucher',
            selector: (row: TransactionVoucherUsage) => row.voucher,
            sortable: true,
            wrap: true,
        },
        {
            name: 'Keterangan Pemakaian',
            selector: (row: TransactionVoucherUsage) => row.keterangan_pemakaian,
            sortable: true,
            wrap: true,
        },
        {
            name: 'Tanggal Pemakaian',
            selector: (row: TransactionVoucherUsage) => row.tanggal_pemakaian,
            sortable: true,
            wrap: true,
        },
        {
            name: 'Aksi',
            cell: (row: TransactionVoucherUsage) => (
                <div className="space-x-1">
                    <Button size="icon" variant="destructive" onClick={() => onDelete(row.id)}>
                        <Trash />
                    </Button>
                </div>
            ),
            width: '11rem',
        },
    ];

    const data = (voucherUsages ?? []).map((voucherUsage, index) => ({
        index: index + 1,
        id: voucherUsage.id,
        keterangan_pemakaian: voucherUsage.keterangan_pemakaian,
        voucher: `${voucherUsage.voucher.m_voucher_type.nama} - ${voucherUsage.voucher.deskripsi}`,
        tanggal_pemakaian: voucherUsage.tanggal_pemakaian,
    }));

    const searchBy = ['keterangan_pemakaian', 'voucher', 'tanggal_pemakaian'];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Transaksi Pemakaian Voucher" />
            <div className="mb-4 flex gap-4">
                <Link href={route('voucher-usage.create')} className="inline-block">
                    <Button>Tambah</Button>
                </Link>
            </div>
            <DataTables columns={columns} data={data ?? []} searchBy={searchBy} />
        </AppLayout>
    );
}
