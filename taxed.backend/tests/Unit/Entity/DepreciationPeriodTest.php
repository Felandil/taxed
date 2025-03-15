<?php

namespace Tests\Unit\Entity;

use App\Entity\DepreciationPeriod;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class DepreciationPeriodTest extends TestCase
{
  public function testPeriodGenerationHasCorrectFormat()
  {
    $period = new DepreciationPeriod(Carbon::parse('01.10.2021'), Carbon::parse('30.09.2022'), 100.44);

    $this->assertEquals(100.44, $period->getDepreciation());
    $this->assertEquals('01.10.2021-30.09.2022', $period->format());
  }
}