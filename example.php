<?php

function calculateSum(array $numbers): int|float {
    $sum = 0;
    foreach ($numbers as $value) {
        $sum += $value;
    }
    return $sum;
}

$numbers = [1, 2, 3, 4, 5];
echo 'Сумма чисел: ' . calculateSum($numbers);