<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling(); //To get the actual Exception whenever it occurs instead of Laravel handing the exception.
    }
}
