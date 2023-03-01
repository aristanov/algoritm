<?php


/**
 * Реализация бинарного поиска
 */
function search(array $data, int $number): int
{
    //левая и правая граница поиска
    $left = -1;
    $right = count($data);

    while ($left < $right - 1) {    //поиск

        $middle = $left + intdiv(($right - $left), 2);  //находим середину области поиска

        if ($data[$middle] < $number) {
            $left = $middle;    //ищем в правой части
        } elseif ($data[$middle] > $number) {
            $right = $middle;   //ищем в левой части
        } else {
            return $middle; //элемент найден
        }
    }

    return -1;  //элемент не найден
}


/**
 * Поиск выходных в интервале дат
 */
function weekend(string $begin, string $end): int
{
    $date_begin = new DateTime($begin);
    $date_end = new DateTime($end);
    $week_begin = ($date_begin->format('w') > 0) ? $date_begin->format('w') : 7;
    $week_end = ($date_end->format('w') > 0) ? $date_end->format('w') : 7;
    $count_weekend = 0;

    if ($date_begin == $date_end and ($week_begin == 7 and $week_end == 7)) {   //если выбрано одно воскресенье
        return 1;
    }

    //начинаем диапазон с следующей субботы
    if ($week_begin != 6) {
        $date_begin->modify('next Saturday');
    }
    //добавляем 1 выходной, если диапазон начинается с воскреснья
    if ($week_begin == 7) {
        $count_weekend += 1;
    }

    //определяем пятницу как конец диапазона
    if ($week_end > 5) {
        $date_end->modify('last Friday');
        $count_weekend += ($week_end - 5);
    } elseif ($week_end < 5) {
        $date_end->modify('next Friday');
    }

    //вычисляем выходные в диапазоне
    if ($date_begin < $date_end) {
        $count_weekend += round((($date_end->diff($date_begin))->format('%a') * 2) / 7);    //по формуле (end - start) * 2 / 7
    }

    return $count_weekend;
}

