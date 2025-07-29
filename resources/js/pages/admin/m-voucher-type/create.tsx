import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import { BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';

interface FormData {
    nama: string;
}

export default function CreateVoucherType() {
    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Tipe Voucher',
            href: route('m-voucher-type.index'),
        },
        {
            title: 'Tambah',
            href: route('m-voucher-type.create'),
        },
    ];

    const { data, setData, post, errors, processing } = useForm<Required<FormData>>({
        nama: '',
    });

    const handleOnSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('m-voucher-type.store'));
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Tipe Voucher" />
            <form onSubmit={handleOnSubmit} className="space-y-4">
                <div>
                    <Label htmlFor="nama">Nama</Label>
                    <Input
                        id="nama"
                        type="text"
                        required
                        placeholder="Masukkan nama tipe voucher"
                        value={data.nama}
                        onChange={(e) => setData('nama', e.target.value)}
                    />
                    <InputError message={errors.nama} />
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
