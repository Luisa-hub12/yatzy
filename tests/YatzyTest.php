<?php

declare(strict_types=1);

namespace Yatzy\Tests;

use PHPUnit\Framework\TestCase;
use Yatzy\yatzy;

class YatzyTest extends TestCase
{
    public function testChanceScoresSumOfAllDice(): void
    {
        $expected = 15;
        $actual = yatzy::chance(2, 3, 4, 5, 1);
        self::assertSame($expected, $actual);
        self::assertSame(16, yatzy::chance(3, 3, 4, 5, 1));
    }

    public function testYatzyScores50(): void
    {
        $expected = 50;
        $actual = yatzy::yatzyScore([4, 4, 4, 4, 4]);
        self::assertSame($expected, $actual);
        self::assertSame(50, yatzy::yatzyScore([6, 6, 6, 6, 6]));
        self::assertSame(0, yatzy::yatzyScore([6, 6, 6, 6, 3]));
    }

    public function test1s(): void
    {
        self::assertSame(1, yatzy::ones(1, 2, 3, 4, 5));
        self::assertSame(2, yatzy::ones(1, 2, 1, 4, 5));
        self::assertSame(0, yatzy::ones(6, 2, 2, 4, 5));
        self::assertSame(4, yatzy::ones(1, 2, 1, 1, 1));
    }

    public function test2s(): void
    {
        self::assertSame(4, yatzy::twos(1, 2, 3, 2, 6));
        self::assertSame(10, yatzy::twos(2, 2, 2, 2, 2));
    }

    public function testThrees(): void
    {
        self::assertSame(6, yatzy::threes(1, 2, 3, 2, 3));
        self::assertSame(12, yatzy::threes(2, 3, 3, 3, 3));
    }

    public function testFoursTest(): void
    {
        self::assertSame(12, (new yatzy(4, 4, 4, 5, 5))->fours());
        self::assertSame(8, (new yatzy(4, 4, 5, 5, 5))->fours());
        self::assertSame(4, (new yatzy(4, 5, 5, 5, 5))->fours());
    }

    public function testFives(): void
    {
        self::assertSame(10, (new yatzy(4, 4, 4, 5, 5))->Fives());
        self::assertSame(15, (new yatzy(4, 4, 5, 5, 5))->Fives());
        self::assertSame(20, (new yatzy(4, 5, 5, 5, 5))->Fives());
    }

    public function sixes_test(): void
    {
        self::assertSame(0, (new yatzy(4, 4, 4, 5, 5))->sixes());
        self::assertSame(6, (new yatzy(4, 4, 6, 5, 5))->sixes());
        self::assertSame(18, (new yatzy(6, 5, 6, 6, 5))->sixes());
    }

    public function testOnePair(): void
    {
        self::assertSame(6, (new yatzy(3, 4, 3, 5, 6))->score_pair(3, 4, 3, 5, 6));
        self::assertSame(10, (new yatzy(5, 3, 3, 3, 5))->score_pair(5, 3, 3, 3, 5));
        self::assertSame(12, (new yatzy(5, 3, 6, 6, 5))->score_pair(5, 3, 6, 6, 5));
    }

    public function testTwoPair(): void
    {
        self::assertSame(16, yatzy::two_pair(3, 3, 5, 4, 5));
        self::assertSame(18, yatzy::two_pair(3, 3, 6, 6, 6));
        self::assertSame(0, yatzy::two_pair(3, 3, 6, 5, 4));
    }

    public function testThreeOfAKind(): void
    {
        self::assertSame(9, yatzy::three_of_a_kind(3, 3, 3, 4, 5));
        self::assertSame(15, yatzy::three_of_a_kind(5, 3, 5, 4, 5));
        self::assertSame(9, yatzy::three_of_a_kind(3, 3, 3, 2, 1));
    }

    public function testSmallStraight(): void
    {
        self::assertSame(15, yatzy::smallStraight(1, 2, 3, 4, 5));
        self::assertSame(15, yatzy::smallStraight(2, 3, 4, 5, 1));
        self::assertSame(0, yatzy::smallStraight(1, 2, 2, 4, 5));
    }

    public function testLargeStraight(): void
    {
        self::assertSame(20, yatzy::largeStraight(6, 2, 3, 4, 5));
        self::assertSame(20, yatzy::largeStraight(2, 3, 4, 5, 6));
        self::assertSame(0, yatzy::largeStraight(1, 2, 2, 4, 5));
    }

    public function testFullHouse(): void
    {
        self::assertSame(18, yatzy::fullHouse(6, 2, 2, 2, 6));
        self::assertSame(0, yatzy::fullHouse(2, 3, 4, 5, 6));
    }
}