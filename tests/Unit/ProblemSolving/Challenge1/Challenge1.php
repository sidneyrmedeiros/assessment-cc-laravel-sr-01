<?php

namespace Tests\Unit\ProblemSolving\Challenge1;

class Challenge1
{
    public static function numberFractionsCalculator($numbers)
    {
        $positives = 0;
        $negative = 0;
        $zeros = 0;
        $total = count($numbers);

        foreach ($numbers as $key => $value) {
            if ($value > 0) {
                $positives += 1;
            } elseif ($value < 0) {
                $negative += 1;
            } else {
                $zeros++;
            }
        }
        return [
            'positives' => number_format($positives / $total, 6),
            'negative' => number_format($negative / $total, 6),
            'zeros' => number_format($zeros / $total, 6)
        ];
    }
}
