<?php

/**
 * Выделить уникальные записи (убрать дубли) в отдельный массив.
 * в конечном массиве не должно быть элементов с одинаковым id.
 *
 * @param array $input
 * @return array
 */
function firstTask(array $input): array
{
    $uniqueIds = [];

    return array_filter($input, static function ($value) use (&$uniqueIds) {
        if (in_array($value['id'], $uniqueIds))
        {
            return false;
        }
        else
        {
            $uniqueIds[] = $value['id'];
            return true;
        }
    });
}


/**
 * Отсортировать многомерный массив по ключу (любому)
 *
 * @param array $input
 * @param string $key
 * @return array
 */
function secondTask(array $input, string $key): array
{
    $result = $input;

    usort($result, static function($a, $b) use ($key) {
        return $a[$key] <=> $b[$key];
    });

    return $result;
}


/**
 * Вернуть из массива только элементы, удовлетворяющие внешним условиям
 * (например элементы с определенным id)
 *
 * @param array $input
 * @param string $key
 * @param string $value
 * @return array
 */
function thirdTask(array $input, string $key, string $value): array
{
    return array_filter($input, fn($row) => $row[$key] == $value);
}


/**
 * Изменить в массиве значения и ключи (использовать name => id в качестве пары ключ => значение)
 *
 * @param array $input
 * @return array
 */
function fourthTask(array $input): array
{
    $result = [];

    array_walk($input, static function($row) use (&$result) {
       $key = $row['name'];
       $result[$key] = $row['id'];
    });

    return $result;
}