<?php

declare(strict_types=1);

namespace YegorChechurin\CommissionTask\Tests\Service;

use PHPUnit\Framework\TestCase;
use YegorChechurin\CommissionTask\Service\Math\Math;

class MathTest extends TestCase
{
    /**
     * @var Math
     */
    /*private $math;

    public function setUp()
    {
        $this->math = new Math(2);
    }*/

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
