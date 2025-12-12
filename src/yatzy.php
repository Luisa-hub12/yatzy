<?php

declare(strict_types=1);

namespace Yatzy;

class Yatzy
{

    /**
     * @var array<int, int>
     */
    private array $dice;



    public function __construct(int $d1, int $d2, int $d3, int $d4, int $d5)
    {
        $this->dice = array_fill(0, 5, 0);
        $this->dice[0] = $d1;
        $this->dice[1] = $d2;
        $this->dice[2] = $d3;
        $this->dice[3] = $d4;
        $this->dice[4] = $d5;
    }

    public static function addSumDice(int $d1, int $d2, int $d3, int $d4, int $d5): int
    {
        $total = 0;
        $total += $d1;
        $total += $d2;
        $total += $d3;
        $total += $d4;
        $total += $d5;
        return $total;
    }

    /**
     * @param array<int, int> $dices
     */
    public static function Score(array $dices): int
    {
        $counts = array_count_values($dices);
        if (in_array(5, $counts)) {
            return 50;
        }

        return 0;
    }

    /**
     * @param array<int, int> $dices
     */
    public static function numberOfValue(array $dices, int $value): int
    {
        $sum = 0;
        foreach ($dices as $dice) {
            if($dice === $value) {
                $sum += $value;
            }
        }
        return $sum;
    }

    //Trop d'arguments dans la fonction, à mettre dans un objet
    public function scorePair(int $d1, int $d2, int $d3, int $d4, int $d5): int
    {
        $counts = array_fill(0, 6, 0);
        ++$counts[$d1 - 1];
        ++$counts[$d2 - 1];
        ++$counts[$d3 - 1];
        ++$counts[$d4 - 1];
        ++$counts[$d5 - 1];
        for ($at = 0; $at !== 6; $at++) {
            if ($counts[6 - $at - 1] === 2) {
                return (6 - $at) * 2;
            }
        }
        return 0;
    }

    public static function TwoPair(int $d1, int $d2, int $d3, int $d4, int $d5): int
    {
        $counts = array_fill(0, 6, 0);
        ++$counts[$d1 - 1];
        ++$counts[$d2 - 1];
        ++$counts[$d3 - 1];
        ++$counts[$d4 - 1];
        ++$counts[$d5 - 1];
        $n = 0;
        $score = 0;
        for ($i = 0; $i !== 6; $i++) {
            if ($counts[6 - $i - 1] >= 2) {
                $n = $n + 1;
                $score += (6 - $i);
            }
        }

        if ($n === 2) {
            return $score * 2;
        }

        return 0;
    }

    public static function threeOfaKind(int $d1, int $d2, int $d3, int $d4, int $d5): int
    {
        $t = array_fill(0, 6, 0);
        ++$t[$d1 - 1];
        ++$t[$d2 - 1];
        ++$t[$d3 - 1];
        ++$t[$d4 - 1];
        ++$t[$d5 - 1];
        for ($i = 0; $i !== 6; $i++) {
            if ($t[$i] >= 3) {
                return ($i + 1) * 3;
            }
        }
        return 0;
    }

    public static function smallStraight(int $d1, int $d2, int $d3, int $d4, int $d5): int
    {
        $tallies = array_fill(0, 6, 0);
        ++$tallies[$d1 - 1];
        ++$tallies[$d2 - 1];
        ++$tallies[$d3 - 1];
        ++$tallies[$d4 - 1];
        ++$tallies[$d5 - 1];
        if ($tallies[0] === 1 &&
            $tallies[1] === 1 &&
            $tallies[2] === 1 &&
            $tallies[3] === 1 &&
            $tallies[4] === 1) {
            return 15;
        }
        return 0;
    }

    public static function largeStraight(int $d1, int $d2, int $d3, int $d4, int $d5): int
    {
        $tallies = array_fill(0, 6, 0);
        ++$tallies[$d1 - 1];
        ++$tallies[$d2 - 1];
        ++$tallies[$d3 - 1];
        ++$tallies[$d4 - 1];
        ++$tallies[$d5 - 1];
        if ($tallies[1] === 1 &&
            $tallies[2] === 1 &&
            $tallies[3] === 1 &&
            $tallies[4] === 1 &&
            $tallies[5] === 1) {
            return 20;
        }
        return 0;
    }

    public static function House(int $d1, int $d2, int $d3, int $d4, int $d5): int
    {
        $tallies = [];
        $_2 = false;
        $i = 0;
        $_2_at = 0;
        $_3 = false;
        $_3_at = 0;

        $tallies = array_fill(0, 6, 0);
        ++$tallies[$d1 - 1];
        ++$tallies[$d2 - 1];
        ++$tallies[$d3 - 1];
        ++$tallies[$d4 - 1];
        ++$tallies[$d5 - 1];

        foreach (range(0, 5) as $i) {
            if ($tallies[$i] === 2) {
                $_2 = true;
                $_2_at = $i + 1;
            }
        }

        foreach (range(0, 5) as $i) {
            if ($tallies[$i] === 3) {
                $_3 = true;
                $_3_at = $i + 1;
            }
        }

        if ($_2 && $_3) {
            return $_2_at * 2 + $_3_at * 3;
        }

        return 0;
    }
}