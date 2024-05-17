<?php

namespace Tests\Unit;

use Tests\TestCase;

class CalculatorTest extends TestCase
{
    public function test_quit()
    {
        $this->runCalculatorTest('quit', 'Exiting the calculator. Goodbye!');
    }

    public function test_addition()
    {
        $this->runCalculatorTest('3 + 5', 'Result: 8');
    }

    public function test_subtraction()
    {
        $this->runCalculatorTest('10 - 4', 'Result: 6');
    }

    public function test_multiplication()
    {
        $this->runCalculatorTest('7 * 6', 'Result: 42');
    }

    public function test_division()
    {
        $this->runCalculatorTest('8 / 2', 'Result: 4');
    }

    public function test_division_by_zero()
    {
        $this->runCalculatorTest('8 / 0', 'Result: Division by zero error');
    }

    public function test_square_root()
    {
        $this->runCalculatorTest('16 sqrt', 'Result: 4');
    }

    public function test_invalid_input_format()
    {
        $this->runCalculatorTest('4 unknown 4324', 'Invalid input format.');
    }

    private function runCalculatorTest($input, $output)
    {
        $this->artisan('calculator')
            ->expectsQuestion('Syntax: {number} {operation} {number?}) or type "quit" to exit', $input)
            ->expectsOutput($output)
            ->when($input !== 'quit', function ($command) {
                $command->expectsQuestion('Syntax: {number} {operation} {number?}) or type "quit" to exit', 'quit')
                    ->expectsOutput('Exiting the calculator. Goodbye!');
            })
            ->assertExitCode(0);
    }
}
