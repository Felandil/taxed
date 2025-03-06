<?php

namespace Tests\Unit\Services;

use App\Repository\Models\AssetCategorySQLiteModel;
use App\Repository\Models\MovableAssetSQLiteModel;
use App\Services\DepreciationCalculator;
use Carbon\Carbon;
use Tests\Unit\MovableAssetTestCase;

class DepreciationCalculatorTest extends MovableAssetTestCase
{
  function testStuff()
  {
    $this->markTestSkipped("This test is not implemented yet.");

    // $assetCategory = new AssetCategorySQLiteModel();
    // $assetCategory->id = 1;
    // $assetCategory->useful_life = 3;

    // $asset = new MovableAssetSQLiteModel();
    // $asset->exists = true;
    // $asset->id = 1;
    // $asset->name = 'SomeAsset';
    // $asset->price = 969.29;
    // $asset->bookedAt = Carbon::parse('28.09.2021');
    // $asset->category = $assetCategory;

    // $result = DepreciationCalculator::calculateDepreciation($asset);
  }
}