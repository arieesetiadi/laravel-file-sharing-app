<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Display cms dashboard.
     */
    public function dashboard(): View
    {
        $data['title'] = 'Dashboard';
        $data['count'] = [
            'admin' => User::admin()->count(),
            'customer' => User::customer()->count(),
        ];

        return view('cms.dashboard', $data);
    }
}
