<?php

namespace App\Http\Controllers\CMS\Auth;

use App\Http\Controllers\Controller;
use App\Traits\HasWebResponses;
use Illuminate\Http\RedirectResponse;

class LogoutController extends Controller
{
    use HasWebResponses;

    /**
     * Logout the current logged in user.
     */
    public function process(): RedirectResponse
    {
        // Logout cms user
        auth('cms')->logout();
        return redirect()->route('cms.auth.login.index');
    }
}
