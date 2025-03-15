<?php

use App\Entity\AssetCategory;

class AssetCategoryDTO
{
    /**
   * @var int
   */
  private $id;

  /**
   * @var string
   */
  private $name;

  /**
   * @var int
   */
  private $usefulLife;

  /**
   * @var int
   */
  private $depreciationRate;

    /**
   * @return int
   */
  public function getId(): int
  {
    return $this->id;
  }

  /**
   * @return string
   */
  public function getName(): string
  {
    return $this->name;
  }

  /**
   * @return int
   */
  public function getUsefulLife(): int
  {
    return $this->usefulLife;
  }

  /**
   * @return int
   */
  public function getDepreciationRate(): int
  {
    return $this->depreciationRate;
  }

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