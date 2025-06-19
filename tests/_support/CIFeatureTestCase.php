<?php

namespace Tests\Support;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class CIFeatureTestCase extends CIUnitTestCase
{
    use FeatureTestTrait;

    /**
     * Ativa migrations automáticas com rollback para cada teste
     */
    protected $migrate = true;
    protected $refresh = true;
    protected $namespace = 'App';
}
