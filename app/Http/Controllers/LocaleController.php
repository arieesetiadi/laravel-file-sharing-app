<?php

namespace App\Http\Controllers;

use App\Constants\AppLocale;
use App\Traits\HasWebResponses;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class LocaleController extends Controller
{
    use HasWebResponses;

    /**
     * Switch app locale / language.
     */
    public function switch(Request $request): RedirectResponse
    {
        $locales = AppLocale::values();
        $locale = in_array($request->locale, $locales) ? $request->locale : $locales[0];

        session()->put('locale', $locale);

        $referer = $request->headers->get('Referer');
        $routeName = Route::getRoutes()->match(request()->create($referer))->getName();

        return redirect()->route($routeName, $locale);
    }
}
