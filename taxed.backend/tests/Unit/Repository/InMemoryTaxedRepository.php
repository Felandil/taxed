<?php

namespace Tests\Unit\Repository;

use App\Repository\ITaxedRepository;
use App\Repository\Models\MovableAsset;
use App\Repository\Models\AssetCategory;

class InMemoryTaxedRepository implements ITaxedRepository
{
  public $throwException = false;
  private $assetCategories = [];
  private $assets;

  /**
   * @param AssetCategory[] $assetCategories
   * @param MovableAsset[] $assets
   */
  public function __construct(array $assetCategories, array $assets)
  {
    $this->assetCategories = $assetCategories;
    $this->assets = $assets;
  }

  public function addMovableAsset(string $name, float $price, int $categoryId): MovableAsset
  {
    if ($this->throwException) {
      throw new \Exception('Some error');
    }

    $asset = new MovableAsset();
    $asset->name = $name;
    $asset->price = $price;
    $asset->bookedAt = date('Y-m-d H:i:s');
    $asset->assetCategoryId = $categoryId;
    $asset->exists = true;

    return $asset;
  }

  public function getMovableAssetCategoryById(int $id): ?AssetCategory
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

  public function getMovableAssetById(int $id): ?MovableAsset
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