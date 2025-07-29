import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import { BreadcrumbItem, MVoucherType, Outlet } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';

interface FormData {
    outlet_id: number;
    m_voucher_type_id: number;
    deskripsi: string;
    tanggal_terbit: string;
    tanggal_kadaluarsa: string;
    status: 'active' | 'inactive';
}

export default function CreateVoucher() {
    const { mVoucherTypes, outlets } = usePage().props as { mVoucherTypes?: MVoucherType[]; outlets?: Outlet[] };

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Voucher',
            href: route('voucher.index'),
        },
        {
            title: 'Tambah',
            href: route('voucher.create'),
        },
    ];

    const { data, setData, post, errors, processing } = useForm<Required<FormData>>({
        outlet_id: 0,
        m_voucher_type_id: 0,
        deskripsi: '',
        tanggal_terbit: '',
        tanggal_kadaluarsa: '',
        status: 'inactive',
    });

    const handleOnSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('voucher.store'));
    };

    const statusOptions = [
        { label: 'Aktif', value: 'active' },
        { label: 'Tidak Aktif', value: 'inactive' },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Voucher" />
            <form onSubmit={handleOnSubmit} className="space-y-4">
                <div>
                    <Label htmlFor="outlet_id">Outlet</Label>
                    <Select value={data.outlet_id ? String(data.outlet_id) : ''} onValueChange={(value) => setData('outlet_id', Number(value))}>
                        <SelectTrigger className="w-full" aria-label="Pilih Outlet">
                            <SelectValue placeholder="Pilih Outlet" />
                        </SelectTrigger>
                        <SelectContent>
                            {outlets?.map((outlet) => (
                                <SelectItem key={outlet.id} value={String(outlet.id)}>
                                    {outlet.nama}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                    <InputError message={errors.outlet_id} />
                </div>
                <div>
                    <Label htmlFor="m_voucher_type_id">Tipe Voucher</Label>
                    <Select
                        value={data.m_voucher_type_id ? String(data.m_voucher_type_id) : ''}
                        onValueChange={(value) => setData('m_voucher_type_id', Number(value))}
                    >
                        <SelectTrigger className="w-full" aria-label="Pilih Tipe Voucher">
                            <SelectValue placeholder="Pilih Tipe Voucher" />
                        </SelectTrigger>
                        <SelectContent>
                            {mVoucherTypes?.map((voucherType) => (
                                <SelectItem key={voucherType.id} value={String(voucherType.id)}>
                                    {voucherType.nama}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                    <InputError message={errors.m_voucher_type_id} />
                </div>
                <div>
                    <Label htmlFor="deskripsi">Deskripsi</Label>
                    <Input
                        id="deskripsi"
                        type="text"
                        required
                        placeholder="Masukkan deskripsi voucher"
                        value={data.deskripsi}
                        onChange={(e) => setData('deskripsi', e.target.value)}
                    />
                    <InputError message={errors.deskripsi} />
                </div>
                <div>
                    <Label htmlFor="tanggal_terbit">Tanggal Terbit</Label>
                    <Input
                        id="tanggal_terbit"
                        type="date"
                        required
                        placeholder="Masukkan tanggal terbit voucher"
                        value={data.tanggal_terbit}
                        onChange={(e) => setData('tanggal_terbit', e.target.value)}
                    />
                    <InputError message={errors.tanggal_terbit} />
                </div>
                <div>
                    <Label htmlFor="tanggal_kadaluarsa">Tanggal Kadaluarsa</Label>
                    <Input
                        id="tanggal_kadaluarsa"
                        type="date"
                        required
                        placeholder="Masukkan tanggal kadaluarsa voucher"
                        value={data.tanggal_kadaluarsa}
                        onChange={(e) => setData('tanggal_kadaluarsa', e.target.value)}
                    />
                    <InputError message={errors.tanggal_kadaluarsa} />
                </div>
                <div>
                    <Label htmlFor="status">Status</Label>
                    <Select
                        value={data.status ? String(data.status) : ''}
                        onValueChange={(value) => setData('status', value as 'active' | 'inactive')}
                    >
                        <SelectTrigger className="w-full" aria-label="Pilih Status">
                            <SelectValue placeholder="Pilih Status" />
                        </SelectTrigger>
                        <SelectContent>
                            {statusOptions?.map((status) => (
                                <SelectItem key={status.value} value={String(status.value)}>
                                    {status.label}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                    <InputError message={errors.m_voucher_type_id} />
                </div>
                <div className="flex justify-end">
                    <Button type="submit" variant="default" disabled={processing}>
                        {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                        Simpan
                    </Button>
                </div>
            </form>
        </AppLayout>
    );
}
