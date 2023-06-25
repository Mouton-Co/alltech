<?php

namespace App\Http\Controllers;

use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if (User::find(auth()->user()->id)->hasRole('admin')) {
            return view('dashboards.admin-dashboard');
        } else {
            return view('dashboards.sales-dashboard');
        }
    }
}
