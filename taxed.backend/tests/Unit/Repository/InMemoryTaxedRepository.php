<?php

namespace Tests\Unit\Repository;

use App\Repository\ITaxedRepository;
use App\Models\MovableAsset;
use App\Models\AssetCategory;

class InMemoryTaxedRepository implements ITaxedRepository
{
  public $throwException = false;
  private $movableAssetCategories = [];

  /**
   * @param AssetCategory[] $assetCategories
   */
  public function __construct(array $assetCategories)
  {
    $this->movableAssetCategories = $assetCategories;
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

    foreach ($this->movableAssetCategories as $category) {
      if ($category->id === $id) {
        return $category;
      }
    }

    return null;
  }
}