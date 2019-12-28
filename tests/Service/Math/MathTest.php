<?php

//declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Tests\Service;

use PHPUnit\Framework\TestCase;
use YegorChechurin\CommissionTask\Service\Math\Math;
use YegorChechurin\CommissionTask\Service\Math\Exception\LogicException\NumberIsNotDecimalException;
use YegorChechurin\CommissionTask\Service\Math\Exception\LogicException\InvalidPostionAfterPointException;

class MathTest extends TestCase
{
    /**
     * @var Math
     */
    private $math;

    public function setUp()
    {
        $this->math = new Math();
    }

    /**
     * @dataProvider decimalNumberProvider
     */
    public function testCheckNumberIsDecimalTrue($number)
    {
        $this->assertTrue($this->math->checkNumberIsDecimal($number));
    }

    /**
     * @dataProvider integerNumberProvider
     */
    public function testCheckNumberIsDecimalNotTrue($number)
    {
        $this->assertNotTrue($this->math->checkNumberIsDecimal($number));
    }

    /**
     * @dataProvider integerNumberProvider
     */
    public function testSplitDecimalIntoWholeAndFractional($number)
    {
        $this->expectException(NumberIsNotDecimalException::class);

        $this->math->splitDecimalIntoWholeAndFractional($number);
    }

    public function decimalNumberProvider()
    {
        return [
            ['25.456'], ['8.17']
        ];
    }

    public function integerNumberProvider()
    {
        return [
            ['8'], ['777']
        ];
    }

    public function testExceptionalRoundSpecificDigitAfterPointToUpperBound()
    {
        $this->expectException(InvalidPostionAfterPointException::class);

        $this->math->roundSpecificDigitAfterPointToUpperBound('12.13', -5);
    }

    /** 
     * @dataProvider roundSpecificDigitAfterPointToUpperBoundProvider 
     */
    public function testRoundSpecificDigitAfterPointToUpperBound(string $decimal, int $positionAfterPoint, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->math->roundSpecificDigitAfterPointToUpperBound(
                $decimal, $positionAfterPoint
            )
        );
    }

    public function roundSpecificDigitAfterPointToUpperBoundProvider()
    {
        return [
            ['0.6948197328804', 2, '0.70'],
            ['0.69999999999', 3, '0.700'],
            ['12.131', 2, '12.14'],
            ['12.00001', 4, '12.0001'],
            ['12.00', 0, '12'],
            ['12.0000000001', 0, '13'],
            ['12.9999999', 0, '13'],
            ['0.5', 2, '0.50'],
            ['0.5', 3, '0.500'],
        ];
    }

    /** 
     * @dataProvider convertIntegerToFloatProvider 
     */
    public function testConvertIntegerToFloat(string $integer, int $positionAfterPoint, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->math->convertIntegerToFloat(
                $integer, $positionAfterPoint
            )
        );
    }

    public function convertIntegerToFloatProvider()
    {
        return [
            ['0', 2, '0.00'],
            ['5', 3, '5.000'],
        ];
    }
}
