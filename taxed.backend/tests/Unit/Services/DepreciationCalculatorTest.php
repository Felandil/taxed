<?php

namespace Tests\Unit\Services;

use App\Entity\AssetCategory;
use App\Entity\MovableAsset;
use App\Services\DepreciationCalculator;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class DepreciationCalculatorTest extends TestCase
{
  function testThreeYearDepreciationWithinFourYearsCalculatesCorrectly()
  {
    $assetCategory = new AssetCategory(1, "", 3, 3);
    $asset = new MovableAsset(1, "SomeAsset", 969.29, Carbon::parse('28.09.2021'), $assetCategory);

    $calculator = new DepreciationCalculator(Carbon::parse('01.10.2021'), Carbon::parse('30.09.2021'));

    $result = $calculator->calculateDepreciation($asset);

    $sum = array_reduce($result, function ($carry, $item) {
      return $carry + $item->getDepreciation();
    }, 0);

    $this->assertEquals(969.29, $sum);
    $this->assertEquals(26.92, $result[0]->getDepreciation());
    $this->assertEquals(323.04, $result[1]->getDepreciation());
    $this->assertEquals(323.04, $result[2]->getDepreciation());
    $this->assertEquals(296.29, $result[3]->getDepreciation());
  }

  function testThreeYearDepreciationWithinThreeYearsCalculatesCorrectly()
  {
    $assetCategory = new AssetCategory(1, "", 3, 3);
    $asset = new MovableAsset(1, "SomeAsset", 999, Carbon::parse('08.10.2022'), $assetCategory);

    $calculator = new DepreciationCalculator(Carbon::parse('01.10.2021'), Carbon::parse('30.09.2021'));

    $result = $calculator->calculateDepreciation($asset);

    $sum = array_reduce($result, function ($carry, $item) {
      return $carry + $item->getDepreciation();
    }, 0);

    $this->assertEquals(999.00, $sum);
    $this->assertEquals(333.00, $result[0]->getDepreciation());
    $this->assertEquals(333.00, $result[1]->getDepreciation());
    $this->assertEquals(333.00, $result[2]->getDepreciation());
  }

  function testSixYearDepreciationWithinSevenYearsStartingInMiddleCalculatesCorrectly()
  {
    $assetCategory = new AssetCategory(1, "", 6, 6);
    $asset = new MovableAsset(1, "SomeAsset", 1996.99, Carbon::parse('23.11.2017'), $assetCategory);

    $calculator = new DepreciationCalculator(Carbon::parse('01.10.2021'), Carbon::parse('30.09.2021'));

    $result = $calculator->calculateDepreciation($asset);

    $sum = array_reduce($result, function ($carry, $item) {
      return $carry + $item->getDepreciation();
    }, 0);

    $this->assertEquals(1996.99, round($sum, 2));
    $this->assertEquals(305.14, $result[0]->getDepreciation());
    $this->assertEquals(332.88, $result[1]->getDepreciation());
    $this->assertEquals(332.88, $result[2]->getDepreciation());
    $this->assertEquals(332.88, $result[3]->getDepreciation());
    $this->assertEquals(332.88, $result[4]->getDepreciation());
    $this->assertEquals(332.88, $result[5]->getDepreciation());
    $this->assertEquals(27.45, $result[6]->getDepreciation());
  }
}