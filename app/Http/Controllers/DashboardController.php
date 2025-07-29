<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    private function admin()
    {
        return Inertia::render('admin/dashboard');
    }

    private function userOutlet()
    {
        return Inertia::render('user-outlet/dashboard');
    }

    public function dashboard(Request $request)
    {
        $user = $request->user();

        if ($user->outlet_id == null) {
            return $this->admin();
        } else {
            return $this->userOutlet();
        }
    }
}
