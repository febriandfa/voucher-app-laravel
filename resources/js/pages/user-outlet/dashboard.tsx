import DataCard from '@/components/data-card';
import AppLayout from '@/layouts/app-layout';
import { BreadcrumbItem, Outlet, SharedData } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import { Receipt, Ticket, User } from 'lucide-react';

export default function DashboardUserOutlet() {
    const { auth } = usePage<SharedData>().props;

    const { outlet, totalVoucher, totalRecipient, totalTransactionVoucherReceipt, totalTransactionVoucherUsage } = usePage().props as {
        outlet?: Outlet;
        totalVoucher?: number;
        totalRecipient?: number;
        totalTransactionVoucherReceipt?: number;
        totalTransactionVoucherUsage?: number;
    };

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Dashboard',
            href: '/dashboard',
        },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <h1 className="mb-4 text-lg font-bold">
                Selamat datang, {auth.user.name}! <br />
                Kelola voucher dan pantau aktivitas di {outlet?.nama ?? '-'}.
            </h1>
            <div className="grid grid-cols-2 gap-4">
                <DataCard category="Total Voucher" number={totalVoucher ?? 0} icon={<Ticket />} />
                <DataCard category="Total Penerima Voucher" number={totalRecipient ?? 0} icon={<User />} />
                <DataCard category="Total Voucher Belum Digunakan" number={totalTransactionVoucherReceipt ?? 0} icon={<Receipt />} />
                <DataCard category="Total Voucher Sudah Digunakan" number={totalTransactionVoucherUsage ?? 0} icon={<Receipt />} />
            </div>
        </AppLayout>
    );
}
