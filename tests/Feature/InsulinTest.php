<?php
namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use App\Services\InsulinCalculator;

class InsulinCalculatorTest extends CIUnitTestCase
{
    public function test_calculates_dose_correctly()
    {
        $calculator = new InsulinCalculator();
        $result = $calculator->calculateDose(120, 60, 15); // glicemia atual, alvo, fator de correção
        $this->assertEquals(4, $result);
    }
}
