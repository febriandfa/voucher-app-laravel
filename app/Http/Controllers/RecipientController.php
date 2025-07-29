<?php

namespace App\Http\Controllers;

use App\Services\RecipientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class RecipientController extends Controller
{
    protected $recipientService;

    public function __construct(RecipientService $recipientService)
    {
        $this->recipientService = $recipientService;
    }

    public function index()
    {
        $recipients = $this->recipientService->getAll();

        return Inertia::render('user-outlet/recipient/index', compact('recipients'));
    }

    public function create()
    {
        return Inertia::render('user-outlet/recipient/create');
    }

    public function store(Request $request)
    {
        try {
            $this->recipientService->create($request->only([
                'nama',
                'no_wa',
                'email'
            ]));

            return redirect()->route('recipient.index')->with('success', 'Recipient created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Error during recipient creation: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $recipient = $this->recipientService->findById($id);

        if (!$recipient) {
            return redirect()->route('recipient.index')->with('error', 'Recipient not found.');
        }

        return Inertia::render('user-outlet/recipient/edit', compact('recipient'));
    }

    public function update(Request $request, $id)
    {
        try {
            $this->recipientService->update($id, $request->only([
                'nama',
                'no_wa',
                'email'
            ]));

            return redirect()->route('recipient.index')->with('success', 'Recipient updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Error during recipient update: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->recipientService->delete($id);

            return redirect()->route('recipient.index')->with('success', 'Recipient deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error during recipient deletion: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
