<?php

namespace App\Repository;

use App\Repository\Models\MovableAssetSQLiteModel;
use App\Repository\Models\AssetCategorySQLiteModel;

interface ITaxedRepository
{
  /**
   * @param int $id
   * 
   * @return ?AssetCategorySQLiteModel
   */
  function getMovableAssetCategoryById(int $id): ?AssetCategorySQLiteModel;

  /**
   * @param string $name
   * @param float $price
   * @param int $categoryId
   * 
   * @return MovableAssetSQLiteModel
   */
  function addMovableAsset(string $name, float $price, int $categoryId): MovableAssetSQLiteModel;

  /**
   * @param int $id
   * 
   * @return ?MovableAssetSQLiteModel
   */
  function getMovableAssetById(int $id): ?MovableAssetSQLiteModel;
}