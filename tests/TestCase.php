<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\ExpectationFailedException;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    private $validationErrors;

    private $errorBag = '';

    private $expectValidationException = false;

    protected function runTest()
    {
        try {
            parent::runTest();

            if ($this->expectValidationException) {
                throw new ExpectationFailedException('ValidationException not thrown');
            }
        } catch (ValidationException $e) {
            if (! $this->expectValidationException) {
                throw $e;
            }

            $this->assertEquals($this->validationErrors, $e->errors());
            $this->assertEquals($this->errorBag, $e->errorBag);
        }
    }

    protected function expectValidationException(array $expected, string $errorBag = '')
    {
        $this->expectValidationException = true;
        $this->validationErrors = $expected;
        $this->errorBag = $errorBag;
    }
}
