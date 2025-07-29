import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { SharedData, type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { House, LayoutGrid, Receipt, Send, Ticket, User } from 'lucide-react';
import AppLogo from './app-logo';

export function AppSidebar() {
    const { auth } = usePage<SharedData>().props;

    const adminNavItems: NavItem[] = [
        {
            title: 'Dashboard',
            href: '/dashboard',
            icon: LayoutGrid,
        },
        {
            title: 'Tipe Voucher',
            href: route('m-voucher-type.index'),
            icon: Ticket,
        },
        {
            title: 'Outlet',
            href: route('outlet.index'),
            icon: House,
        },
    ];

    const outletNavItems: NavItem[] = [
        {
            title: 'Dashboard',
            href: '/dashboard',
            icon: LayoutGrid,
        },
        {
            title: 'Voucher',
            href: route('voucher.index'),
            icon: Ticket,
        },
        {
            title: 'Penerima Voucher',
            href: route('recipient.index'),
            icon: User,
        },
        {
            title: 'Kirim Voucher',
            href: route('send-voucher.create'),
            icon: Send,
        },
        {
            title: 'Transaksi Penerimaan Voucher',
            href: route('voucher-receipt.index'),
            icon: Receipt,
        },
        {
            title: 'Transaksi Pemakaian Voucher',
            href: route('voucher-usage.index'),
            icon: Receipt,
        },
    ];

    const mainNavItems: NavItem[] = auth.user.outlet_id ? outletNavItems : adminNavItems;

    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href="/dashboard" prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
