<?php

namespace App\Repository;

use App\Repository\Models\MovableAsset;
use App\Repository\Models\AssetCategory;
use Illuminate\Database\DatabaseManager;

class TaxedSQLiteRepository implements ITaxedRepository
{
  protected $database;

  public function __construct(DatabaseManager $database)
  {
    $this->database = $database;
  }

  /**
   * @return MovableAsset[]
   */
  public function loadMovableAssets(): array
  {
    $movableAssets = MovableAsset::all();

    return $movableAssets->toArray();
  }

  /**
   * @param int $id
   * 
   * @return AssetCategory|null
   */
  public function getMovableAssetCategoryById(int $id): ?AssetCategory
  {
    return AssetCategory::find($id);
  }

  /**
   * @param string $name
   * @param float $price
   * @param int $categoryId
   * 
   * @return MovableAsset
   */
  public function addMovableAsset(string $name, float $price, int $categoryId): MovableAsset
  {
    $asset = new MovableAsset();
    $asset->name = $name;
    $asset->price = $price;
    $asset->bookedAt = date('Y-m-d H:i:s');
    $asset->asset_category_id = $categoryId;

    $asset->save();

    return $asset;
  }

  public function getMovableAssetById(int $id): ?MovableAsset
  {
    return MovableAsset::find($id);
  }
}