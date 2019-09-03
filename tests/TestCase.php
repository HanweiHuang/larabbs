<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    const DATABASE_NAME = 'sqlite';

    protected $seeder_include = [];

    public function setUp()
    {
        parent::setUp();
        Artisan::call('migrate', ['--database' => self::DATABASE_NAME]);
        $this->runSeeders();
    }

    /**
     * run each seeders
     */
    private function runSeeders()
    {
        if(!empty($this->seeder_include)){
            foreach ($this->seeder_include as $seeder){
                Artisan::call('db:seed', ['--class' => $seeder, '--database' => self::DATABASE_NAME]);
            }
        }
    }
}
