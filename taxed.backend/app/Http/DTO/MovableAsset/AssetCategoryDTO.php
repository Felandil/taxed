<?php

namespace App\Http\DTO\MovableAsset;

use App\Entity\AssetCategory;

class AssetCategoryDTO
{
    /**
   * @var int
   */
  public $id;

  /**
   * @var string
   */
  public $name;

  /**
   * @var int
   */
  public $usefulLife;

  /**
   * @var int
   */
  public $depreciationRate;

  /**
   * @param AssetCategory $category
   * 
   * @return AssetCategoryDTO
   */
  public static function fromEntity(AssetCategory $category): AssetCategoryDTO
  {
    $dto = new self();
    $dto->id = $category->getId();
    $dto->name = $category->getName();
    $dto->usefulLife = $category->getUsefulLife();
    $dto->depreciationRate = $category->getDepreciationRate();

    return $dto;
  }
}