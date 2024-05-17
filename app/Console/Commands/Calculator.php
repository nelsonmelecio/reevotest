<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Calculator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculator';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform basic calculator operations';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('LEGEND:');
        $this->info('   number    -> any valid numbers');
        $this->info('   number?   -> any valid numbers but optional and will be discarded for Square root operations only. Ex. 9 sqrt');
        $this->info('   operation -> mathematical operation you want to implement');
        $this->info('');
        $this->info('Make sure to separate the numbers and operation with a space.');
        $this->info('');

        $this->info('Available operations:');
        $this->info('(+)    Addition');
        $this->info('(-)    Subtraction');
        $this->info('(*)    Multiplication');
        $this->info('(/)    Division');
        $this->info('(sqrt) Square root');

        while (true) {
            $input = $this->ask('Syntax: {number} {operation} {number?}) or type "quit" to exit');

            if (strtolower($input) === 'quit') {
                $this->info('Exiting the calculator. Goodbye!');
                break;
            }

            [$arg1, $operation, $arg2] = array_pad(explode(' ', $input), 3, null);

            if (! $this->validateInput($arg1, $operation, $arg2)) {
                $this->error('Invalid input format.');

                continue;
            }

            $result = $this->calculate($operation, $arg1, $arg2);

            if ($result !== null) {
                $this->info('Result: '.$result);
            } else {
                $this->error('Invalid operation or arguments.');
            }
        }

        return 0;
    }

    /**
     * Perform the calculation.
     *
     * @param  string  $operation
     * @param  mixed  $arg1
     * @param  mixed  $arg2
     * @return mixed
     */
    protected function calculate($operation, $arg1, $arg2 = null)
    {
        $arg1 = is_numeric($arg1) ? $arg1 : null;
        $arg2 = is_numeric($arg2) ? $arg2 : null;

        switch ($operation) {
            case '+':
                return $arg1 + $arg2;
            case '-':
                return $arg1 - $arg2;
            case '*':
                return $arg1 * $arg2;
            case '/':
                if ($arg2 == 0) {
                    return 'Division by zero error';
                }

                return $arg1 / $arg2;
            case 'sqrt':
                return sqrt($arg1);
            default:
                return null;
        }
    }

    /**
     * Validate the input format.
     *
     * @param  mixed  $arg1
     * @param  mixed  $operation
     * @param  mixed  $arg2
     * @return bool
     */
    protected function validateInput($arg1, $operation, $arg2)
    {
        if (! is_numeric($arg1) || ! in_array($operation, ['+', '-', '*', '/', 'sqrt'])) {
            return false;
        }

        if ($operation !== 'sqrt' && ! is_numeric($arg2)) {
            return false;
        }

        return true;
    }
}
