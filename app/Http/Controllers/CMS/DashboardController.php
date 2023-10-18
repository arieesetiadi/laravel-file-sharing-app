<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Share;
use App\Models\User;
use App\Services\ShareService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display cms dashboard.
     */
    public function dashboard(): View
    {
        $data['user'] = User::query()->find(Auth::id());
        $data['shares'] = Auth::user()->is_admin ? (new ShareService)->all() : (new ShareService)->getByUserId(Auth::id());

        $data['title'] = 'Dashboard';
        $data['count'] = [
            'shares' => Share::query()->count(),
            'files' => File::query()->count(),
        ];


        return view('cms.dashboard', $data);
    }
}
