<?php

namespace Tests\Unit\Repository;

use App\Entity\AssetCategory;
use App\Entity\MovableAsset;
use App\Repository\ITaxedRepository;
use DateTime;

class InMemoryTaxedRepository implements ITaxedRepository
{
  public $throwException = false;
  private $assetCategories = [];
  private $assets = [];

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

    $category = $this->getMovableAssetCategoryById($categoryId);
    $asset = new MovableAsset(1, $name, $price, new DateTime(), $category);
    array_push($this->assets, $asset);

    return $asset;
  }

  public function getMovableAssetCategoryById(int $id): ?AssetCategory
  {
    if ($this->throwException) {
      throw new \Exception('Some error');
    }

    foreach ($this->assetCategories as $category) {
      if ($category->getId() === $id) {
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
      if ($asset->getId() === $id) {
        return $asset;
      }
    }

    return null;
  }
}