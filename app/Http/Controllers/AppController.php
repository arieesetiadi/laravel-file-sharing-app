<?php

namespace App\Http\Controllers;

use App\Traits\HasWebResponses;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;

class AppController extends Controller
{
    use HasWebResponses;

    /**
     * Clear laravel application.
     */
    public function clear(): RedirectResponse
    {
        Artisan::call('app:clear');

        return $this->success('The process has been completed successfully.');
    }

    /**
     * Optimize laravel application.
     */
    public function optimize(): RedirectResponse
    {
        Artisan::call('app:optimize');

        return $this->success('The process has been completed successfully.');
    }
}
