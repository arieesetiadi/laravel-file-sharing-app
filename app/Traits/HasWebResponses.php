<?php

namespace App\Traits;

use App\Constants\SwalButton;
use App\Constants\SwalIcon;
use Illuminate\Http\RedirectResponse;

trait HasWebResponses
{
    /**
     * Get flash session with success sweet alert data.
     */
    public static function success(string $text, string $redirectUrl = null): RedirectResponse
    {
        $redirectUrl = $redirectUrl ?? back()->getTargetUrl();

        $icon = SwalIcon::SUCCESS;
        $title = SwalIcon::label($icon);
        $button = SwalButton::OK;

        return redirect()->to($redirectUrl)->with('swal', [
            'title' => $title,
            'text' => $text,
            'icon' => $icon,
            'button' => $button,
        ]);
    }

    /**
     * Get flash session with failed sweet alert data.
     */
    public static function failed(string $text, string $redirectUrl = null): RedirectResponse
    {
        $redirectUrl = $redirectUrl ?? back()->getTargetUrl();

        $icon = SwalIcon::ERROR;
        $title = SwalIcon::label($icon);
        $button = SwalButton::OK;

        return redirect()->to($redirectUrl)->with('swal', [
            'title' => $title,
            'text' => $text,
            'icon' => $icon,
            'button' => $button,
        ]);
    }
}
