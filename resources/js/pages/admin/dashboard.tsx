import DataCard from '@/components/data-card';
import AppLayout from '@/layouts/app-layout';
import { BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import { House, Receipt, Ticket, User } from 'lucide-react';

export default function DashboardAdmin() {
    const { totalOutlet, totalVoucher, totalRecipient, totalTransactionVoucherReceipt, totalTransactionVoucherUsage } = usePage().props as {
        totalOutlet?: number;
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
            <div className="grid grid-cols-3 gap-4">
                <DataCard category="Total Outlet" number={totalOutlet ?? 0} icon={<House />} />
                <DataCard category="Total Voucher" number={totalVoucher ?? 0} icon={<Ticket />} />
                <DataCard category="Total Penerima Voucher" number={totalRecipient ?? 0} icon={<User />} />
                <DataCard category="Total Voucher Belum Digunakan" number={totalTransactionVoucherReceipt ?? 0} icon={<Receipt />} />
                <DataCard category="Total Voucher Sudah Digunakan" number={totalTransactionVoucherUsage ?? 0} icon={<Receipt />} />
            </div>
        </AppLayout>
    );
}
