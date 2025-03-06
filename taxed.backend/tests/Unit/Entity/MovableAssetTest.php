<?php

namespace Tests\Unit\Entity;

use App\Entity\AssetCategory;
use App\Entity\MovableAsset;
use DateTime;
use PHPUnit\Framework\TestCase;

class MovableAssetTest extends TestCase
{
  public function testDepreciationMonthIsCalculatedCorrectly()
  {
    $asset = new MovableAsset(1, "SomeAsset", 360, new DateTime(), new AssetCategory(1, "", 3, 3));

    $this->assertEquals(36, $asset->getDepreciationMonthCount());
  }

  public function testDepreciationAmountPerMonthIsCalculatedCorrectly()
  {
    $asset = new MovableAsset(1, "SomeAsset", 360, new DateTime(), new AssetCategory(1, "", 3, 3));

    $this->assertEquals(10, $asset->getMonthlyDepreciation());

    $asset = new MovableAsset(1, "SomeAsset", 280, new DateTime(), new AssetCategory(1, "", 3, 3));

    $this->assertEquals(7.78, $asset->getMonthlyDepreciation());

    $asset = new MovableAsset(1, "SomeAsset", 260, new DateTime(), new AssetCategory(1, "", 3, 3));

    $this->assertEquals(7.22, $asset->getMonthlyDepreciation());
  }

  public function testDepreciationAmountDifferenceIsCalculatedCorrectly()
  {
    $asset = new MovableAsset(1, "SomeAsset", 360, new DateTime(), new AssetCategory(1, "", 3, 3));

    $this->assertEquals(0, $asset->getDepreciationAmountDifference());

    $asset = new MovableAsset(1, "SomeAsset", 280, new DateTime(), new AssetCategory(1, "", 3, 3));

    $this->assertEquals(-0.08, $asset->getDepreciationAmountDifference());
    $this->assertEquals(280, $asset->getMonthlyDepreciation() * $asset->getDepreciationMonthCount() + $asset->getDepreciationAmountDifference());

    $asset = new MovableAsset(1, "SomeAsset", 260, new DateTime(), new AssetCategory(1, "", 3, 3));

    $this->assertEquals(0.08, $asset->getDepreciationAmountDifference());
    $this->assertEquals(260, $asset->getMonthlyDepreciation() * $asset->getDepreciationMonthCount() + $asset->getDepreciationAmountDifference());
  }
}