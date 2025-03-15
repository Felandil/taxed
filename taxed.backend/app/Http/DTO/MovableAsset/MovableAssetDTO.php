<?php

use App\Entity\DepreciationPeriod;
use App\Entity\MovableAsset;

class MovableAssetDTO
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
   * @var float
   */
  private $price;

  /**
   * @var string
   */
  private $priceFormatted;

  /**
   * @var string
   */
  private $bookedAt;

  /**
   * @var float
   */
  private $monthlyDepreciation;

  /**
   * @var string
   */
  private $monthlyDepreciationFormatted;

  /**
   * @var AssetCategoryDTO
   */
  private $category;

  /**
   * @return DepreciationPeriodDTO[]
   */
  private $depreciation;

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
   * @return float
   */
  public function getPrice(): float
  {
    return $this->price;
  }

  /**
   * @return string
   */
  public function getPriceFormatted(): string
  {
    return $this->priceFormatted;
  }

  /**
   * @return DateTime
   */
  public function getBookedAt(): string
  {
    return $this->bookedAt;
  }

  /**
   * @return AssetCategoryDTO
   */
  public function getCategory(): AssetCategoryDTO
  {
    return $this->category;
  }

  /**
   * @return DepreciationPeriodDTO[]
   */
  public function getDepreciation(): DepreciationPeriodDTO
  {
    return $this->depreciation;
  }

  /**
   * @param MovableAsset $entity
   * @param DepreciationPeriodDTO[] $depreciationPeriods
   * 
   * @return void
   */
  public static function fromEntity(MovableAsset $entity, array $depreciationPeriods): self
  {
    
  }
}