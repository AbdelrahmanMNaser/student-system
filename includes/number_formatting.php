<?php
function toOrdinary($number) {
    if (!is_numeric($number)) {
        throw new InvalidArgumentException("Input must be a number.");
    }

    $number = intval($number);
    $lastTwoDigits = $number % 100;
    $lastDigit = $number % 10;

    if ($lastTwoDigits >= 11 && $lastTwoDigits <= 13) {
        return $number . 'th';
    }

    switch ($lastDigit) {
        case 1:
            return $number . 'st';
        case 2:
            return $number . 'nd';
        case 3:
            return $number . 'rd';
        default:
            return $number . 'th';
    }
}