<?php

namespace App\Http\Controllers;

use App\Services\MVoucherTypeService;
use App\Services\OutletService;
use App\Services\VoucherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class VoucherController extends Controller
{
    protected $voucherService;
    protected $mVoucherService;
    protected $outletService;

    public function __construct(VoucherService $voucherService, MVoucherTypeService $mVoucherService, OutletService $outletService)
    {
        $this->voucherService = $voucherService;
        $this->mVoucherService = $mVoucherService;
        $this->outletService = $outletService;
    }

    public function index()
    {
        $admin = Auth::user()->outlet_id == null;

        if ($admin) {
            $vouchers = $this->voucherService->getAll();

            return Inertia::render('admin/voucher/index', compact('vouchers'));
        } else {
            $vouchers = $this->voucherService->getByOutletId(Auth::user()->outlet_id);

            return Inertia::render('user-outlet/voucher/index', compact('vouchers'));
        }
    }

    public function create()
    {
        $admin = Auth::user()->outlet_id == null;

        if ($admin) {
            $mVoucherTypes = $this->mVoucherService->getAll();
            $outlets = $this->outletService->getAll();

            return Inertia::render('admin/voucher/create', compact('mVoucherTypes', 'outlets'));
        } else {
            $mVoucherTypes = $this->mVoucherService->getAll();

            return Inertia::render('user-outlet/voucher/create', compact('mVoucherTypes'));
        }
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
        $admin = Auth::user()->outlet_id == null;

        if ($admin) {
            $mVoucherTypes = $this->mVoucherService->getAll();
            $outlets = $this->outletService->getAll();
            $voucher = $this->voucherService->findById($id);

            if (!$voucher) {
                return redirect()->route('voucher.index')->with('error', 'Voucher not found.');
            }

            return Inertia::render('admin/voucher/edit', compact('mVoucherTypes', 'outlets', 'voucher'));
        } else {
            $mVoucherTypes = $this->mVoucherService->getAll();
            $voucher = $this->voucherService->findById($id);

            if (!$voucher) {
                return redirect()->route('voucher.index')->with('error', 'Voucher not found.');
            }

            return Inertia::render('user-outlet/voucher/edit', compact('mVoucherTypes', 'voucher'));
        }
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
