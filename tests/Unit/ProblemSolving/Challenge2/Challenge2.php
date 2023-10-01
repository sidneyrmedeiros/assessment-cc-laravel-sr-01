<?php

namespace Tests\Unit\ProblemSolving\Challenge2;

use Exception;

class Challenge2
{
    public static function diceFacesCalculator($dice1, $dice2, $dice3)
    {
        $dices = [$dice1, $dice2, $dice3];
        $countValues = array_count_values($dices);
        foreach ($countValues as $key => $value) {

            if ($key > 6 || $key < 1) {
                throw new Exception('Dice out of number range');

            }

            if ($value > 1) {
                return $key * $value;
            }
        }
        return max($dices);
    }
}
