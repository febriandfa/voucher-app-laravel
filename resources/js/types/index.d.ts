import { LucideIcon } from 'lucide-react';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
    [key: string]: unknown;
}

export interface User {
    id: number;
    name: string;
    email: string;
    outlet_id: number | null;
    outlet?: Outlet;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}

export interface Outlet {
    id: number;
    nama: string;
    user?: User;
    created_at: string;
    updated_at: string;
    [key: string]: unknown;
}

export interface MVoucherType {
    id: number;
    nama: string;
    created_at: string;
    updated_at: string;
    [key: string]: unknown;
}

export interface Voucher {
    id: number;
    outlet_id: number;
    outlet: Outlet;
    m_voucher_type_id: number;
    m_voucher_type: MVoucherType;
    deskripsi: string;
    tanggal_terbit: string;
    tanggal_kadaluarsa: string;
    status: 'active' | 'inactive';
    [key: string]: unknown;
}
