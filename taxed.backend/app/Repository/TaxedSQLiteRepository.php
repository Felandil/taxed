<?php

namespace App\Repository;

use App\Entity\AssetCategory;
use App\Entity\MovableAsset;
use App\Repository\Models\AssetCategorySQLiteModel;
use App\Repository\Models\MovableAssetSQLiteModel;
use DateTime;
use Illuminate\Database\DatabaseManager;

class TaxedSQLiteRepository implements ITaxedRepository
{
  protected $database;

  public function __construct(DatabaseManager $database)
  {
    $this->database = $database;
  }

  /**
   * @param int $id
   * 
   * @return AssetCategory|null
   */
  public function getMovableAssetCategoryById(int $id): ?AssetCategory
  {
    return AssetCategorySQLiteModel::find($id)?->toEntity();
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
    $bookedAt = new DateTime();

    $asset = new MovableAssetSQLiteModel();
    $asset->name = $name;
    $asset->price = $price;
    $asset->bookedAt = $bookedAt->format('Y-m-d H:i:s');
    $asset->asset_category_id = $categoryId;

    $asset->save();

    return $asset->toEntity();
  }

  public function getMovableAssetById(int $id): ?MovableAsset
  {
    return MovableAssetSQLiteModel::find($id)?->toEntity();
  }
}