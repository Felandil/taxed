<?php

namespace Tests\Unit\Services;

use App\Repository\Models\AssetCategory;
use App\Repository\Models\MovableAsset;
use App\Services\DepreciationCalculator;
use Carbon\Carbon;
use Tests\Unit\MovableAssetTestCase;

class DepreciationCalculatorTest extends MovableAssetTestCase
{
  function testStuff()
  {
    $assetCategory = new AssetCategory();
    $assetCategory->id = 1;
    $assetCategory->useful_life = 3;

    $asset = new MovableAsset();
    $asset->exists = true;
    $asset->id = 1;
    $asset->name = 'SomeAsset';
    $asset->price = 969.29;
    $asset->bookedAt = Carbon::parse('28.09.2021');
    $asset->category = $assetCategory;

    $result = DepreciationCalculator::calculateDepreciation($asset);

    echo json_encode($result, JSON_PRETTY_PRINT);
  }
}