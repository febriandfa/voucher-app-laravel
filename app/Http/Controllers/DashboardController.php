<?php

namespace App\Http\Controllers;

use App\Services\OutletService;
use App\Services\RecipientService;
use App\Services\TransactionVoucherReceiptService;
use App\Services\TransactionVoucherUsageService;
use App\Services\VoucherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    protected $outletService;
    protected $voucherService;
    protected $recipientService;
    protected $transactionVoucherReceiptService;
    protected $transactionVoucherUsageService;

    public function __construct(
        OutletService $outletService,
        VoucherService $voucherService,
        RecipientService $recipientService,
        TransactionVoucherReceiptService $transactionVoucherReceiptService,
        TransactionVoucherUsageService $transactionVoucherUsageService
    ) {
        $this->outletService = $outletService;
        $this->voucherService = $voucherService;
        $this->recipientService = $recipientService;
        $this->transactionVoucherReceiptService = $transactionVoucherReceiptService;
        $this->transactionVoucherUsageService = $transactionVoucherUsageService;
    }

    private function admin()
    {
        $totalOutlet = $this->outletService->getAll()->count();
        $totalVoucher = $this->voucherService->getAll()->count();
        $totalRecipient = $this->recipientService->getAll()->count();
        $totalTransactionVoucherReceipt = $this->transactionVoucherReceiptService->getAll()->count();
        $totalTransactionVoucherUsage = $this->transactionVoucherUsageService->getAll()->count();

        return Inertia::render('admin/dashboard', compact(
            'totalOutlet',
            'totalVoucher',
            'totalRecipient',
            'totalTransactionVoucherReceipt',
            'totalTransactionVoucherUsage'
        ));
    }

    private function userOutlet()
    {
        $outletId = Auth::user()->outlet_id;

        $outlet = $this->outletService->findById($outletId);
        $totalVoucher = $this->voucherService->getActiveByOutletId($outletId)->count();
        $totalRecipient = $this->recipientService->getAll()->count();
        $totalTransactionVoucherReceipt = $this->transactionVoucherReceiptService->getByOutletId($outletId)->count();
        $totalTransactionVoucherUsage = $this->transactionVoucherUsageService->getByOutletId($outletId)->count();

        return Inertia::render('user-outlet/dashboard', compact(
            'outlet',
            'totalVoucher',
            'totalRecipient',
            'totalTransactionVoucherReceipt',
            'totalTransactionVoucherUsage'
        ));
    }

    public function dashboard(Request $request)
    {
        $user = $request->user();

        if ($user->outlet_id == null) {
            return $this->admin();
        } else {
            return $this->userOutlet();
        }
    }
}
