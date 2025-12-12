<?php

declare(strict_types=1);

namespace Yatzy\Tests;

use PHPUnit\Framework\TestCase;
use Yatzy\Yatzy;

class YatzyTest extends TestCase
{
    public function testChanceScoresSumOfAllDice(): void
    {
        $expected = 15;
        $actual = yatzy::addSumDice(2, 3, 4, 5, 1);
        self::assertSame($expected, $actual);
        self::assertSame(16, yatzy::addSumDice(3, 3, 4, 5, 1));
    }

    public function testYatzyScores50(): void
    {
        $expected = 50;
        $actual = yatzy::Score([4, 4, 4, 4, 4]);
        self::assertSame($expected, $actual);
        self::assertSame(50, yatzy::Score([6, 6, 6, 6, 6]));
        self::assertSame(0, yatzy::Score([6, 6, 6, 6, 3]));
    }

    public function test1s(): void
    {
        self::assertSame(1, yatzy::numberOfValue([1, 2, 3, 4, 5], 1));
        self::assertSame(2, yatzy::numberOfValue([1, 2, 1, 4, 5], 1));
        self::assertSame(0, yatzy::numberOfValue([6, 2, 2, 4, 5],1));
        self::assertSame(4, yatzy::numberOfValue([1, 2, 1, 1, 1],1));
    }

    public function test2s(): void
    {
        self::assertSame(4, yatzy::numberOfValue([1, 2, 3, 2, 6],2));
        self::assertSame(10, yatzy::numberOfValue([2, 2, 2, 2, 2],2));
    }

    public function testThrees(): void
    {
        self::assertSame(6, yatzy::numberOfValue([1, 2, 3, 2, 3],3));
        self::assertSame(12, yatzy::numberOfValue([2, 3, 3, 3, 3],3));
    }

    public function testFoursTest(): void
    {
        self::assertSame(12, yatzy::numberOfValue([4, 4, 4, 5, 5],4));
        self::assertSame(8, yatzy::numberOfValue([4, 4, 5, 5, 5],4));
        self::assertSame(4, yatzy::numberOfValue([4, 5, 5, 5, 5],4));
    }

    public function testFives(): void
    {
        self::assertSame(10, yatzy::numberOfValue([4, 4, 4, 5, 5],5));
        self::assertSame(15, yatzy::numberOfValue([4, 4, 5, 5, 5],5));
        self::assertSame(20, yatzy::numberOfValue([4, 5, 5, 5, 5],5));
    }

    public function sixes_test(): void
    {
        self::assertSame(0, yatzy::numberOfValue([4, 4, 4, 5, 5],6));
        self::assertSame(6, yatzy::numberOfValue([4, 4, 6, 5, 5],6));
        self::assertSame(18, yatzy::numberOfValue([6, 4, 6, 6, 5],6));
    }

    public function testOnePair(): void
    {
        self::assertSame(6, (new yatzy(3, 4, 3, 5, 6))->scorePair(3, 4, 3, 5, 6));
        self::assertSame(10, (new yatzy(5, 3, 3, 3, 5))->scorePair(5, 3, 3, 3, 5));
        self::assertSame(12, (new yatzy(5, 3, 6, 6, 5))->scorePair(5, 3, 6, 6, 5));
    }

    public function testTwoPair(): void
    {
        self::assertSame(16, yatzy::TwoPair(3, 3, 5, 4, 5));
        self::assertSame(18, yatzy::TwoPair(3, 3, 6, 6, 6));
        self::assertSame(0, yatzy::TwoPair(3, 3, 6, 5, 4));
    }

    public function testThreeOfAKind(): void
    {
        self::assertSame(9, yatzy::threeOfaKind(3, 3, 3, 4, 5));
        self::assertSame(15, yatzy::threeOfaKind(5, 3, 5, 4, 5));
        self::assertSame(9, yatzy::threeOfaKind(3, 3, 3, 2, 1));
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
        self::assertSame(18, yatzy::House(6, 2, 2, 2, 6));
        self::assertSame(0, yatzy::House(2, 3, 4, 5, 6));
    }
}