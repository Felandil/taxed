<?php

namespace App\Repository;

use App\Models\MovableAsset;
use App\Models\AssetCategory;

interface ITaxedRepository
{
  function getMovableAssetCategoryById(int $id): ?AssetCategory;

  function addMovableAsset(string $name, float $price, int $categoryId): MovableAsset;
}