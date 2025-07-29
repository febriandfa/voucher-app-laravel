<?php

namespace App\Http\Controllers;

use App\Services\VoucherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class VoucherController extends Controller
{
    protected $voucherService;

    public function __construct(VoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }

    public function index()
    {
        $vouchers = $this->voucherService->getAll();

        return Inertia::render('user-outlet/voucher/index', compact('vouchers'));
    }

    public function create()
    {
        return Inertia::render('user-outlet/voucher/create');
    }

    public function store(Request $request)
    {
        try {
            $this->voucherService->create($request->only([
                'outlet_id',
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
        $mVoucherType = $this->voucherService->findById($id);

        if (!$mVoucherType) {
            return redirect()->route('voucher.index')->with('error', 'Voucher not found.');
        }

        return Inertia::render('user-outlet/voucher/edit', compact('mVoucherType'));
    }

    public function update(Request $request, $id)
    {
        try {
            $this->voucherService->update($id, $request->only([
                'outlet_id',
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
}
