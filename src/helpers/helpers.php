<?php

declare(strict_types=1);

namespace App\helpers;

function generateDatetimeBetween(\DateTimeImmutable $startDate, \DateTimeImmutable $endDate): \DateTimeImmutable {
    $interval = $startDate->diff($endDate);
    $randomSeconds = rand(0, $interval->s);
    $randomDays = rand(0, $interval->d);
    $randomMonths = rand(0, $interval->m);
    $randomYears = rand(0, $interval->y);

    return $startDate->modify("+{$randomYears} years +{$randomMonths} months +{$randomDays} days +{$randomSeconds} seconds");
}

function generateRandomString(int $length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($characters), 0, $length);
}

?>