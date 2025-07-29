<?php

namespace App\Http\Controllers;

use App\Services\MVoucherTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class MVoucherTypeController extends Controller
{
    protected $mVoucherTypeService;

    public function __construct(MVoucherTypeService $mVoucherTypeService)
    {
        $this->mVoucherTypeService = $mVoucherTypeService;
    }

    public function index()
    {
        $mVoucherTypes = $this->mVoucherTypeService->getAll();

        return Inertia::render('admin/m-voucher-type/index', compact('mVoucherTypes'));
    }

    public function create()
    {
        return Inertia::render('admin/m-voucher-type/create');
    }

    public function store(Request $request)
    {
        try {
            $this->mVoucherTypeService->create($request->only(['nama']));

            return redirect()->route('m-voucher-type.index')->with('success', 'Voucher Type created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e);
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            dd($e);
            Log::error('Error during voucher type creation: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $mVoucherType = $this->mVoucherTypeService->findById($id);

        if (!$mVoucherType) {
            return redirect()->route('m-voucher-type.index')->with('error', 'Voucher Type not found.');
        }

        return Inertia::render('admin/m-voucher-type/edit', compact('mVoucherType'));
    }

    public function update(Request $request, $id)
    {
        try {
            $this->mVoucherTypeService->update($id, $request->only(['nama']));

            return redirect()->route('m-voucher-type.index')->with('success', 'Voucher Type updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Error during voucher type update: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->mVoucherTypeService->delete($id);

            return redirect()->route('m-voucher-type.index')->with('success', 'Voucher Type deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error during voucher type deletion: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
