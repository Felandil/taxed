<?php

namespace App\Repository;

use App\Models\MovableAsset;
use App\Models\AssetCategory;

interface ITaxedRepository
{
  /**
   * @param int $id
   * 
   * @return ?AssetCategory
   */
  function getMovableAssetCategoryById(int $id): ?AssetCategory;

  /**
   * @param string $name
   * @param float $price
   * @param int $categoryId
   * 
   * @return MovableAsset
   */
  function addMovableAsset(string $name, float $price, int $categoryId): MovableAsset;

  /**
   * @param int $id
   * 
   * @return ?MovableAsset
   */
  function getMovableAssetById(int $id): ?MovableAsset;
}