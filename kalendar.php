<?php

date_default_timezone_set('Europe/Zagreb');


// Prošli / Sljedeći mjesec
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    // Trenutni mjesec
    $ym = date('Y-m');
}




$timestamp = strtotime($ym . '-01');  
if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

// Današnji datum
$today = date('Y-m-j');

$title = date('F, Y', $timestamp);

// Kreiranje prošlog i sljedećeg mjeseca
$prev = date('Y-m', strtotime('-1 month', $timestamp));
$next = date('Y-m', strtotime('+1 month', $timestamp));

// Broj dana u mjesecu
$day_count = date('t', $timestamp);

// 1:Pon 2:Uto... 7:Nedj
$str = date('N', $timestamp);

// Polje za kalendar
$weeks = [];
$week = '';

// Prazne ćelije koje nisu dio mjeseca
$week .= str_repeat('<td></td>', $str - 1);

for ($day = 1; $day <= $day_count; $day++, $str++) {

    $date = $ym . '-' . $day;
    if ($today == $date) {
        $week .= '<td class="today">';
    } else {
        $week .= '<td>';
    }
    
    $week .= $day . '</td>';

    // Nedjelja || Zadnji dan u mjesecu
    if ($str % 7 == 0 || $day == $day_count) {

        // Zadnji dan u mjesecu
        if ($day == $day_count && $str % 7 != 0) {
            
            $week .= str_repeat('<td></td>', 7 - $str % 7);
        }

        $weeks[] = '<tr>' . $week . '</tr>';

        $week = '';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalendar</title>
    <link rel="stylesheet" href="kalendar.css">
</head>
<body>
<div class="container">
        <ul class="list-inline">
            <li><a href="?ym=<?= $prev; ?>" class="btn btn-link">Previous Month</a></li>
            <li><a href="?ym=<?= $next; ?>" class="btn btn-link">Next month</a></li>
            <li class="list-inline-item"><span class="title"><?= $title; ?></span></li>
        </ul>
        <table>
        <thead>
            <tr>
                <th>PON</th>
                <th>UTO</th>
                <th>SRI</th>
                <th>ČET</th>
                <th>PET</th>
                <th>SUB</th>
                <th>NED</th>
            </tr>
        </thead>
            <?php
                foreach ($weeks as $week) {
                    echo $week;
                }
            ?>
        </table>
    </div>
</body>
</html>