<?php

namespace App\Http\Controllers;

use App\Services\TransactionVoucherReceiptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class TransactionVoucherReceiptController extends Controller
{
    protected $transactionVoucherReceiptService;

    public function __construct(TransactionVoucherReceiptService $transactionVoucherReceiptService)
    {
        $this->transactionVoucherReceiptService = $transactionVoucherReceiptService;
    }

    public function index()
    {
        $voucherReceipts = $this->transactionVoucherReceiptService->getByOutletId(Auth::user()->outlet_id);

        return Inertia::render('user-outlet/voucher-receipt/index', compact('voucherReceipts'));
    }

    public function destroy($id)
    {
        try {
            $this->transactionVoucherReceiptService->delete($id);

            return redirect()->route('transaction-voucher-receipt.index')->with('success', 'Transaction voucher receipt deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error during transaction voucher receipt deletion: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
