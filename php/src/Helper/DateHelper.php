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
            return $interval->y . ' year' . ($interval->y>1 ? 's':'');
        } elseif ($interval->m > 0) {
            return $interval->m . ' month' . ($interval->m>1 ? 's':'');
        } elseif ($interval->d >= 7) {
            $weeks = floor($interval->d / 7);
            return $weeks . ' week'. ($weeks>1 ? 's':'').' ago';
        } elseif ($interval->d > 0) {
            return $interval->d . ' day'. ($interval->d>1 ? 's':'');
        } elseif ($interval->h > 0) {
            return $interval->h . ' hour' . ($interval->h>1 ? 's':'');
        } elseif ($interval->i > 0) {
            return $interval->i . ' minute' . ($interval->i>1 ? 's':'');
        } else {
            return 'couple seconds';
        }
    }
}