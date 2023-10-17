<?php

use App\Models\User;
use Carbon\Carbon;

/**
 * Date format.
 */
const DATE_FORMAT = 'l, j F Y';

/**
 * Time format.
 */
const TIME_FORMAT = 'h:i A';

/**
 * Date and Time format.
 */
const DATE_TIME_FORMAT = DATE_FORMAT . ' ' . TIME_FORMAT;

/**
 * Get authenticated user (web).
 */
if (!function_exists('customer')) {
    function customer(): User
    {
        return auth('web')->user();
    }
}

/**
 * Get authenticated user (cms).
 */
if (!function_exists('admin')) {
    function admin(): User
    {
        return auth('cms')->user();
    }
}

/**
 * Format date for general human.
 */
if (!function_exists('human_date')) {
    function human_date(string $datetime, string $locale = null): string
    {
        $carbon = Carbon::make($datetime);
        $carbon->setLocale($locale);
        $carbon->settings(['formatFunction' => 'translatedFormat']);
        $date = $carbon->format(DATE_FORMAT);

        return $date;
    }
}

/**
 * Format time for general human.
 */
if (!function_exists('human_time')) {
    function human_time(string $datetime, string $locale = null): string
    {
        $carbon = Carbon::make($datetime);
        $carbon->setLocale($locale);
        $carbon->settings(['formatFunction' => 'translatedFormat']);
        $time = $carbon->format(TIME_FORMAT);

        return $time;
    }
}

/**
 * Format datetime for general human.
 */
if (!function_exists('human_datetime')) {
    function human_datetime(string $datetime, string $locale = null): string
    {
        $carbon = Carbon::make($datetime);
        $carbon->setLocale($locale);
        $carbon->settings(['formatFunction' => 'translatedFormat']);
        $datetime = $carbon->format(DATE_TIME_FORMAT);

        return $datetime;
    }
}

/**
 * Format date diff for human.
 */
if (!function_exists('human_datetime_diff')) {
    function human_datetime_diff(string $datetime,string $locale = null): string
    {
        $carbon = Carbon::make($datetime);
        $carbon->setLocale($locale);
        $diff = $carbon->diffForHumans();

        return $diff;
    }
}

/**
 * Determine if a string is an email.
 */
if (!function_exists('is_email')) {
    function is_email(string $string): bool
    {
        // Email regular expression pattern
        $pattern = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
        $result = preg_match($pattern, $string);

        return $result;
    }
}

/**
 * Determine if a string is a phone number.
 */
if (!function_exists('is_phone')) {
    function is_phone(string $string): bool
    {
        // Phone number regular expression pattern
        $pattern = '/^\+?[1-9]\d{1,14}$/';
        $result = preg_match($pattern, $string);

        return $result;
    }
}

/**
 * Normalize phone number format (+62).
 */
if (!function_exists('normalize_phone')) {
    function normalize_phone(string $phone): string
    {
        // Remove any non-digit characters from the phone number
        $phone = preg_replace('/\D/', '', $phone);

        // Check if the phone number starts with '0'
        if (substr($phone, 0, 1) === '0') {
            // Replace the leading '0' with '+62'
            $phone = '+62' . substr($phone, 1);
        }

        return $phone ?: null;
    }
}

/**
 * Check a select option should be "selected" or not.
 */
if (!function_exists('check_selected')) {
    function check_selected(mixed $value, mixed $comparator)
    {
        if ($value !== null && $comparator !== null) {
            return ($value == $comparator) ? 'selected' : '';
        }
    }
}
