<?php

namespace Helper;
use DateTime;

class DateHelper
{
    public static function timeDifference($created_at)
    {
        $now = new DateTime();

        $posted_time = new DateTime($created_at);

        $interval = $now->diff($posted_time);

        if ($interval->y > 0) {
            return $interval->y . ' tahun lalu';
        } elseif ($interval->m > 0) {
            return $interval->m . ' bulan lalu';
        } elseif ($interval->d >= 7) {
            $weeks = floor($interval->d / 7);
            return $weeks . ' minggu lalu';
        } elseif ($interval->d > 0) {
            return $interval->d . ' hari lalu';
        } elseif ($interval->h > 0) {
            return $interval->h . ' jam lalu';
        } elseif ($interval->i > 0) {
            return $interval->i . ' menit lalu';
        } else {
            return 'beberapa detik lalu';
        }
    }
}
