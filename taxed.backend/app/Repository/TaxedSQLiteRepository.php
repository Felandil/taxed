<?php

namespace App\Repository;

use App\Repository\Models\MovableAssetSQLiteModel;
use App\Repository\Models\AssetCategorySQLiteModel;
use Illuminate\Database\DatabaseManager;

class TaxedSQLiteRepository implements ITaxedRepository
{
  protected $database;

  public function __construct(DatabaseManager $database)
  {
    $this->database = $database;
  }

  /**
   * @return MovableAssetSQLiteModel[]
   */
  public function loadMovableAssets(): array
  {
    $movableAssets = MovableAssetSQLiteModel::all();

    return $movableAssets->toArray();
  }

  /**
   * @param int $id
   * 
   * @return AssetCategorySQLiteModel|null
   */
  public function getMovableAssetCategoryById(int $id): ?AssetCategorySQLiteModel
  {
    return AssetCategorySQLiteModel::find($id);
  }

  /**
   * @param string $name
   * @param float $price
   * @param int $categoryId
   * 
   * @return MovableAssetSQLiteModel
   */
  public function addMovableAsset(string $name, float $price, int $categoryId): MovableAssetSQLiteModel
  {
    $asset = new MovableAssetSQLiteModel();
    $asset->name = $name;
    $asset->price = $price;
    $asset->bookedAt = date('Y-m-d H:i:s');
    $asset->asset_category_id = $categoryId;

    $asset->save();

    return $asset;
  }

  public function getMovableAssetById(int $id): ?MovableAssetSQLiteModel
  {
    return MovableAssetSQLiteModel::find($id);
  }
}