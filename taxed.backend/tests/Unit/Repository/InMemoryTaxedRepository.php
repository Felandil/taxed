<?php

namespace Tests\Unit\Repository;

use App\Repository\ITaxedRepository;
use App\Repository\Models\MovableAssetSQLiteModel;
use App\Repository\Models\AssetCategorySQLiteModel;

class InMemoryTaxedRepository implements ITaxedRepository
{
  public $throwException = false;
  private $assetCategories = [];
  private $assets;

  /**
   * @param AssetCategorySQLiteModel[] $assetCategories
   * @param MovableAssetSQLiteModel[] $assets
   */
  public function __construct(array $assetCategories, array $assets)
  {
    $this->assetCategories = $assetCategories;
    $this->assets = $assets;
  }

  public function addMovableAsset(string $name, float $price, int $categoryId): MovableAssetSQLiteModel
  {
    if ($this->throwException) {
      throw new \Exception('Some error');
    }

    $asset = new MovableAssetSQLiteModel();
    $asset->name = $name;
    $asset->price = $price;
    $asset->bookedAt = date('Y-m-d H:i:s');
    $asset->assetCategoryId = $categoryId;
    $asset->exists = true;

    return $asset;
  }

  public function getMovableAssetCategoryById(int $id): ?AssetCategorySQLiteModel
  {
    if ($this->throwException) {
      throw new \Exception('Some error');
    }

    foreach ($this->assetCategories as $category) {
      if ($category->id === $id) {
        return $category;
      }
    }

    return null;
  }

  public function getMovableAssetById(int $id): ?MovableAssetSQLiteModel
  {
    if ($this->throwException) {
      throw new \Exception('Some error');
    }

    foreach ($this->assets as $asset) {
      if ($asset->id === $id) {
        return $asset;
      }
    }

    return null;
  }
}