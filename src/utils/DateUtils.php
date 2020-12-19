<?php

function getDateForDatabase(string $date): string {
    $timestamp = strtotime($date);
    $date_formated = date('Y-m-d H:i:s', $timestamp);
    return $date_formated;
}
