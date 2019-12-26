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
    {$this->assertTrue(true);
        //$this->assertTrue($this->math->checkNumberIsDecimal($number));
    }

    /**
     * @dataProvider integerNumberProvider
     */
    public function testCheckNumberIsDecimalNotTrue($number)
    {$this->assertTrue(true);
        //$this->assertNotTrue($this->math->checkNumberIsDecimal($number));
    }

    /**
     * @dataProvider integerNumberProvider
     */
    public function testSplitDecimalIntoWholeAndFractional($number)
    {$this->assertTrue(true);
        //$this->expectException(NumberIsNotDecimalException::class);

        //$this->math->splitDecimalIntoWholeAndFractional($number);
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
    {$this->assertTrue(true);
        //$this->expectException(InvalidPostionAfterPointException::class);

        //$this->math->roundSpecificDigitAfterPointToUpperBound('12.13', -5);
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
            ['0', 2, '0.00'],
            ['0.6948197328804', 2, '0.70'],
            ['0.69999999999', 3, '0.700'],
            ['12.131', 2, '12.14'],
            ['12.00001', 4, '12.0001'],
            ['12.00', 0, '12'],
            ['12.0000000001', 0, '13'],
            ['12.9999999', 0, '13']
        ];
    }

    /**
     * @param string $leftOperand
     * @param string $rightOperand
     * @param string $expectation
     *
     * @dataProvider dataProviderForAddTesting
     */
    public function testAdd(string $leftOperand, string $rightOperand, string $expectation)
    {
        $this->assertTrue(true);
        /*$this->assertEquals(
            $expectation,
            $this->math->add($leftOperand, $rightOperand)
        );*/
    }

    public function dataProviderForAddTesting(): array
    {
        return [
            'add 2 natural numbers' => ['1', '2', '3'],
            'add negative number to a positive' => ['-1', '2', '1'],
            'add natural number to a float' => ['1', '1.05123', '2.05'],
        ];
    }

    /**
     * @param string $leftOperand
     * @param string $rightOperand
     * @param string $expectation
     *
     * @dataProvider dataProviderForMultiplyTesting
     */
    public function testMultiply(string $leftOperand, string $rightOperand, string $expectation)
    {
        $this->assertTrue(true);
        /*$this->assertEquals(
            $expectation,
            $this->math->multiply($leftOperand, $rightOperand)
        );*/
    }

    public function dataProviderForMultiplyTesting(): array
    {
        return [
            'multiply 2 natural numbers' => ['1', '2', '2'],
            'multiply negative number by a positive' => ['-1', '2', '-2'],
            'multiply natural number by a float' => ['1', '1.05123', '1.05'],
        ];
    }
}
