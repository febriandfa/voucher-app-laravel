<?php

namespace App\Http\Controllers;

use App\Services\TransactionVoucherUsageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class TransactionVoucherUsageController extends Controller
{
    protected $transactionVoucherUsageService;

    public function __construct(TransactionVoucherUsageService $transactionVoucherUsageService)
    {
        $this->transactionVoucherUsageService = $transactionVoucherUsageService;
    }

    public function index()
    {
        $voucherUsages = $this->transactionVoucherUsageService->getAll();

        return Inertia::render('user-outlet/voucher-usage/index', compact('voucherUsages'));
    }

    public function destroy($id)
    {
        try {
            $this->transactionVoucherUsageService->delete($id);

            return redirect()->route('transaction-voucher-usage.index')->with('success', 'Transaction voucher usage deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error during transaction voucher usage deletion: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
