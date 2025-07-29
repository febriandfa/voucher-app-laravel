<?php

namespace App\Http\Controllers;

use App\Services\ClaimVoucherService;
use App\Services\VoucherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClaimVoucherController extends Controller
{
    protected $claimVoucherService;

    public function __construct(ClaimVoucherService $claimVoucherService)
    {
        $this->claimVoucherService = $claimVoucherService;
    }

    public function store(Request $request)
    {
        try {
            $this->claimVoucherService->claim($request->only(['voucher_id', 'email']));

            return redirect()->back()->with('success', 'Voucher claimed successfully.');
        } catch (\Exception $e) {
            Log::error('Error during voucher claim: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
