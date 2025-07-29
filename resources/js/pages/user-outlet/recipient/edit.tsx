import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import { BreadcrumbItem, Recipient } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';

interface FormData {
    nama: string;
    email: string;
    no_wa: string;
}

export default function EditRecipient() {
    const { recipient } = usePage().props as { recipient?: Recipient };

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Penerima Voucher',
            href: route('recipient.index'),
        },
        {
            title: 'Edit',
            href: route('recipient.edit', recipient?.id),
        },
    ];

    const { data, setData, patch, errors, processing } = useForm<Required<FormData>>({
        nama: recipient?.nama || '',
        email: recipient?.email || '',
        no_wa: recipient?.no_wa || '',
    });

    const handleOnSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        patch(route('recipient.update', recipient?.id));
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Penerima Voucher" />
            <form onSubmit={handleOnSubmit} className="space-y-4">
                <div>
                    <Label htmlFor="nama">Nama Penerima</Label>
                    <Input
                        id="nama"
                        type="text"
                        required
                        placeholder="Masukkan nama penerima"
                        value={data.nama}
                        onChange={(e) => setData('nama', e.target.value)}
                    />
                    <InputError message={errors.nama} />
                </div>
                <div>
                    <Label htmlFor="email">Email Penerima</Label>
                    <Input
                        id="email"
                        type="email"
                        required
                        placeholder="Masukkan email penerima"
                        value={data.email}
                        onChange={(e) => setData('email', e.target.value)}
                    />
                    <InputError message={errors.email} />
                </div>
                <div>
                    <Label htmlFor="no_wa">No WhatsApp Penerima</Label>
                    <Input
                        id="no_wa"
                        type="text"
                        required
                        placeholder="Masukkan no WhatsApp penerima"
                        value={data.no_wa}
                        onChange={(e) => setData('no_wa', e.target.value)}
                    />
                    <InputError message={errors.no_wa} />
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
