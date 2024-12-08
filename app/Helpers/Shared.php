<?php


if (!function_exists('randomToken')) {
    function randomToken() {
        $token = rand(1111, 9999);

        return $token;
    }
}

if (!function_exists('formatPhoneNumber')) {
    function formatPhoneNumber($phoneNumber, $countryCode = '234') {
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        if (strpos($phoneNumber, $countryCode) === 0)
            $phoneNumber = substr($phoneNumber, strlen($countryCode));

        if (strpos($phoneNumber, '0') === 0) $phoneNumber = substr($phoneNumber, 1);

        return $countryCode . $phoneNumber;
    }
}

if (!function_exists('normalizePhoneNumber')) {
    function normalizePhoneNumber(string $number) {
        $number = preg_replace('/[^0-9]/', '', $number);

        if (strlen($number) > 10) $number = substr($number, -10);

        return $number;
    }
}


if (!function_exists('convertToOldFormat')) {
    function convertToOldFormat(string $number) {
        if (substr($number, 0, 3) === '234') {
            return '0' . substr($number, 3);
        }

        return $number;
    }
}

if (!function_exists('number')) {
    function number($value) {
        return (float) $value;
    }
}

if (!function_exists('addZeroPrefixIfNeeded')) {
    function addZeroPrefixIfNeeded(string $number) {
        $number = preg_replace('/[^0-9]/', '', $number);

        if (strlen($number) === 10 && substr($number, 0, 3) !== '234') {
            $number = '0' . $number;
        }

        return $number;
    }
}
