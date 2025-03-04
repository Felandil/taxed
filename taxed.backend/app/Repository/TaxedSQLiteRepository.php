<?php

namespace App\Repository;

use App\Models\MovableAsset;
use App\Models\AssetCategory;
use Illuminate\Database\DatabaseManager;

class TaxedSQLiteRepository implements ITaxedRepository
{
  protected $database;

  public function __construct(DatabaseManager $database)
  {
    $this->database = $database;
  }

  /**
   * @returns MovableAsset[]
   */
  public function loadMovableAssets(): array
  {
    $movableAssets = MovableAsset::all();
    
    return $movableAssets->toArray();
  }

  public function getMovableAssetCategoryById(int $id): ?AssetCategory
  {
    return AssetCategory::find($id);
  }

  public function addMovableAsset(string $name, float $price, int $categoryId): MovableAsset
  {
    $asset = new MovableAsset();
    $asset->name = $name;
    $asset->price = $price;
    $asset->bookedAt = date('Y-m-d H:i:s');
    $asset->assetCategoryId = $categoryId;

    $asset->save();

    return $asset;
  }
}