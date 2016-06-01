<?php

//Date-String Fuktion, die das Argument in Y-m-d H:i:s Form als Datum zurück gibt wie 14. März 15
function formatDateString($DateTimeRaw)
    {
        $date = date_create_from_format('Y-m-d H:i:s', $DateTimeRaw);
        $monate = array(
            1 => 'Januar',
            2 => 'Februar',
            3 => 'März',
            4 => 'April',
            5 => 'Mai',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'August',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Dezember', );
        $monat = $monate[(int) date_format($date, 'm')];
        $printme = date_format($date, 'd').'. '.$monat.' '.date_format($date, 'y');
        return $printme;
    }