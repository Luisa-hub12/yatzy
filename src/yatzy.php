<?php

declare(strict_types=1);

namespace Yatzy;

class yatzy
{
    /**
     * @var array<int, int>
     */
    private array $dice;

    public function __construct(int $d1, int $d2, int $d3, int $d4, int $_5)
    {
        // SMELL: Variable obscure. Le nom $_5 n'est pas clair.
        $this->dice = array_fill(0, 5, 0);
        $this->dice[0] = $d1;
        $this->dice[1] = $d2;
        $this->dice[2] = $d3;
        $this->dice[3] = $d4;
        $this->dice[4] = $_5;
    }

    /**
     * NOUVEAU : Méthode statique utilitaire pour compter les occurrences des dés.
     * Ceci supprime la duplication de code dans toutes les méthodes d'évaluation (yatzyScore, fullHouse, etc.)
     * en acceptant le même format d'input (5 arguments séparés).
     */
    private static function getDiceCountsFromArgs(int $d1, int $d2, int $d3, int $d4, int $d5): array
    {
        $dice = [$d1, $d2, $d3, $d4, $d5];
        $counts = array_fill(0, 6, 0); // Index 0 pour dé 1, index 5 pour dé 6

        foreach ($dice as $die) {
            if ($die >= 1 && $die <= 6) {
                $counts[$die - 1]++;
            }
        }
        return $counts;
    }
    /**
     * SMELL: Incohérence dans l'input.
     * Cette fonction, comme beaucoup d'autres, prend 5 arguments séparés (d1 à d5),
     * alors que les méthodes d'instance (fours, fives, sixes) utilisent le tableau $this->dice.
     * Cela complexifie l'usage.
     */
    public static function chance(int $d1, int $d2, int $d3, int $d4, int $d5): int
    {
        return $d1 + $d2 + $d3 + $d4 + $d5;
    }

    /**
     * @param array<int, int> $dice
     * SMELL : Duplucation de code.
     * La logique de comptage de fréquence des dés (L45-48) est répétée dans presque toutes les fonctions d'évaluation.
     */

    public static function yatzyScore(array $dice): int
    {
        $counts = array_fill(0, 6, 0);
        foreach ($dice as $die) {
            ++$counts[$die - 1];
        }
        foreach (range(0, count($counts) - 1) as $i) {
            if ($counts[$i] === 5) {
                return 50;
            }
        }
        return 0;
    }


    public static function ones(int $d1, int $d2, int $d3, int $d4, int $d5): int
    {
        $sum = 0;
        if ($d1 === 1) {
            ++$sum;
        }
        if ($d2 === 1) {
            ++$sum;
        }
        if ($d3 === 1) {
            ++$sum;
        }
        if ($d4 === 1) {
            ++$sum;
        }
        if ($d5 === 1) {
            ++$sum;
        }

        return $sum;
    }

    public static function twos(int $d1, int $d2, int $d3, int $d4, int $d5): int
    {
        $sum = 0;
        if ($d1 === 2) {
            $sum += 2;
        }
        if ($d2 === 2) {
            $sum += 2;
        }
        if ($d3 === 2) {
            $sum += 2;
        }
        if ($d4 === 2) {
            $sum += 2;
        }
        if ($d5 === 2) {
            $sum += 2;
        }

        return $sum;
    }

    public static function threes(int $d1, int $d2, int $d3, int $d4, int $d5): int
    {
        $s = 0;
        if ($d1 === 3) {
            $s += 3;
        }
        if ($d2 === 3) {
            $s += 3;
        }
        if ($d3 === 3) {
            $s += 3;
        }
        if ($d4 === 3) {
            $s += 3;
        }
        if ($d5 === 3) {
            $s += 3;
        }

        return $s;
    }

    public function fours(): int
    {
        // SMELL: Duplication de logique. La boucle d'itération (L121-124) est répétée dans Fives() et sixes().
        // Ces trois méthodes d'instance devraient utiliser la même logique que ones, twos, threes (mais factorisée).
        $sum = 0;
        for ($at = 0; $at !== 5; $at++) {
            if ($this->dice[$at] === 4) {
                $sum += 4;
            }
        }
        return $sum;
    }

    public function fives(): int
    {
        $s = 0;
        $i = 0;
        for ($i = 0; $i < 5; $i++) {
            if ($this->dice[$i] === 5) {
                $s = $s + 5;
            }
        }
        return $s;
    }

    public function sixes(): int
    {
        $sum = 0;
        for ($at = 0; $at < 5; $at++) {
            if ($this->dice[$at] === 6) {
                $sum = $sum + 6;
            }
        }
        return $sum;
    }
//methode standard yatzy non tester.
    public function sevens(): int
    {
        $sum = 0;
        for ($at = 0; $at < 5; $at++) {
            if ($this->dice[$at] === 7) {
                $sum = $sum + 7;
            }
        }
        return $sum;
    }
    /**
     * SMELL: Duplication de code (L159-161) pour le comptage des dés.
     * Et à nouveau, la méthode prend 5 arguments au lieu d'utiliser $this->dice.
     */
    public function scorePair(int $d1, int $d2, int $d3, int $d4, int $d5): int
    {
        $counts = self::getDiceCountsFromArgs($d1, $d2, $d3, $d4, $d5);
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
    /**
     * SMELL: Duplication de code (L169-172) pour le comptage des dés.
     */
    public static function twoPair(int $d1, int $d2, int $d3, int $d4, int $d5): int
    {
        $counts = self::getDiceCountsFromArgs($d1, $d2, $d3, $d4, $d5);
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
        $t = self::getDiceCountsFromArgs($d1, $d2, $d3, $d4, $d5);
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
        $tallies = self::getDiceCountsFromArgs($d1, $d2, $d3, $d4, $d5);
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
    /**
     * SMELL: Logique complexe et variables obscures (L237-264).
     * Utilisation de booléens et de variables obscures ($_2, $_3, $_2_at, $_3_at).
     * Très difficile à lire et à maintenir, surtout en présence de la duplication de comptage.
     */
    public static function fullHouse(int $d1, int $d2, int $d3, int $d4, int $d5): int
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
