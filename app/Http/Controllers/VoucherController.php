<?php

namespace App\Http\Controllers;

use App\Services\MVoucherTypeService;
use App\Services\VoucherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class VoucherController extends Controller
{
    protected $voucherService;
    protected $mVoucherService;

    public function __construct(VoucherService $voucherService, MVoucherTypeService $mVoucherService)
    {
        $this->voucherService = $voucherService;
        $this->mVoucherService = $mVoucherService;
    }

    public function index()
    {
        $vouchers = $this->voucherService->getAll();

        return Inertia::render('user-outlet/voucher/index', compact('vouchers'));
    }

    public function create()
    {
        $mVoucherTypes = $this->mVoucherService->getAll();

        return Inertia::render('user-outlet/voucher/create', compact('mVoucherTypes'));
    }

    public function store(Request $request)
    {
        try {
            $this->voucherService->create($request->only([
                'm_voucher_type_id',
                'deskripsi',
                'tanggal_terbit',
                'tanggal_kadaluarsa',
                'status'
            ]));

            return redirect()->route('voucher.index')->with('success', 'Voucher created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Error during voucher creation: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $mVoucherTypes = $this->mVoucherService->getAll();
        $voucher = $this->voucherService->findById($id);

        if (!$voucher) {
            return redirect()->route('voucher.index')->with('error', 'Voucher not found.');
        }

        return Inertia::render('user-outlet/voucher/edit', compact('mVoucherTypes', 'voucher'));
    }

    public function update(Request $request, $id)
    {
        try {
            $this->voucherService->update($id, $request->only([
                'm_voucher_type_id',
                'deskripsi',
                'tanggal_terbit',
                'tanggal_kadaluarsa',
                'status'
            ]));

            return redirect()->route('voucher.index')->with('success', 'Voucher updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Error during voucher update: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->voucherService->delete($id);

            return redirect()->route('voucher.index')->with('success', 'Voucher deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error during voucher deletion: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function claim(Request $request)
    {
        try {
            $this->voucherService->claim($request->only(['voucher_id',]));

            return redirect()->back()->with('success', 'Voucher claimed successfully.');
        } catch (\Exception $e) {
            Log::error('Error during voucher claim: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
