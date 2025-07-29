<?php

namespace App\Http\Controllers;

use App\Services\SendVoucherService;
use App\Services\VoucherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class SendVoucherController extends Controller
{
    protected $voucherService;
    protected $sendVoucherService;

    public function __construct(VoucherService $voucherService, SendVoucherService $sendVoucherService)
    {
        $this->voucherService = $voucherService;
        $this->sendVoucherService = $sendVoucherService;
    }

    public function create()
    {
        $vouchers = $this->voucherService->getActiveByOutletId(Auth::user()->outlet_id);

        return Inertia::render('user-outlet/send-voucher/create', compact('vouchers'));
    }

    public function store(Request $request)
    {
        try {
            $this->sendVoucherService->send($request->only([
                'voucher_id',
                'send_type',
                'total',
            ]));

            return redirect()->route('send-voucher.create')->with('success', 'Voucher sent successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Error during voucher sending: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
