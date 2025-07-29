<?php

namespace App\Http\Controllers;

use App\Services\OutletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class OutletController extends Controller
{
    protected $outletService;

    public function __construct(OutletService $outletService)
    {
        $this->outletService = $outletService;
    }

    public function index()
    {
        $outlets = $this->outletService->getAll();

        return Inertia::render('admin/outlet/index', compact('outlets'));
    }

    public function create()
    {
        return Inertia::render('admin/outlet/create');
    }

    public function store(Request $request)
    {
        try {
            $this->outletService->create($request->only(['nama']));

            return redirect()->route('outlet.index')->with('success', 'Outlet created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Error during outlet creation: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $mVoucherType = $this->outletService->findById($id);

        if (!$mVoucherType) {
            return redirect()->route('outlet.index')->with('error', 'Outlet not found.');
        }

        return Inertia::render('admin/outlet/edit', compact('mVoucherType'));
    }

    public function update(Request $request, $id)
    {
        try {
            $this->outletService->update($id, $request->only(['nama']));

            return redirect()->route('outlet.index')->with('success', 'Outlet updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Error during outlet update: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->outletService->delete($id);

            return redirect()->route('outlet.index')->with('success', 'Outlet deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error during outlet deletion: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
