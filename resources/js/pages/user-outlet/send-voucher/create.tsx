import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import { BreadcrumbItem, Voucher } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';

interface FormData {
    voucher_id: number;
    send_type: 'all' | 'random';
    total?: number;
}

export default function CreateSendVoucher() {
    const { vouchers } = usePage().props as { vouchers?: Voucher[] };

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Kirim Voucher',
            href: route('voucher.index'),
        },
    ];

    const { data, setData, post, errors, processing } = useForm<Required<FormData>>({
        voucher_id: 0,
        send_type: 'all',
        total: 1,
    });

    const handleOnSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('send-voucher.store'));
    };

    const statusOptions = [
        { label: 'Semua', value: 'all' },
        { label: 'Acak', value: 'random' },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Kirim Voucher" />
            <form onSubmit={handleOnSubmit} className="space-y-4">
                <div>
                    <Label htmlFor="voucher_id">Voucher</Label>
                    <Select value={data.voucher_id ? String(data.voucher_id) : ''} onValueChange={(value) => setData('voucher_id', Number(value))}>
                        <SelectTrigger className="w-full" aria-label="Pilih Voucher">
                            <SelectValue placeholder="Pilih Voucher" />
                        </SelectTrigger>
                        <SelectContent>
                            {vouchers?.map((voucher) => (
                                <SelectItem key={voucher.id} value={String(voucher.id)}>
                                    {voucher.m_voucher_type.nama} - {voucher.deskripsi}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                    <InputError message={errors.voucher_id} />
                </div>
                <div>
                    <Label htmlFor="send_type">Kirim Ke</Label>
                    <Select
                        value={data.send_type ? String(data.send_type) : ''}
                        onValueChange={(value) => setData('send_type', value as 'all' | 'random')}
                    >
                        <SelectTrigger className="w-full" aria-label="Pilih Jenis Pengiriman">
                            <SelectValue placeholder="Pilih Jenis Pengiriman" />
                        </SelectTrigger>
                        <SelectContent>
                            {statusOptions?.map((status) => (
                                <SelectItem key={status.value} value={String(status.value)}>
                                    {status.label}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                    <InputError message={errors.send_type} />
                </div>
                {data.send_type === 'random' && (
                    <div>
                        <Label htmlFor="total">Total Penerima</Label>
                        <Input
                            id="total"
                            type="number"
                            placeholder="Masukkan total penerima"
                            value={data.total}
                            onChange={(e) => setData('total', Number(e.target.value))}
                        />
                        <InputError message={errors.total} />
                    </div>
                )}
                <div className="flex justify-end">
                    <Button type="submit" variant="default" disabled={processing}>
                        {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                        Kirim
                    </Button>
                </div>
            </form>
        </AppLayout>
    );
}
