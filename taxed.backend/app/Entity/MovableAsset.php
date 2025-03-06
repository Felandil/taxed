<?php

namespace App\Entity;

use DateTime;

class MovableAsset
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
   * @var DateTime
   */
  private $bookedAt;

  /**
   * @var AssetCategory
   */
  private $category;

  /**
   * @param int $id
   * @param string $name
   * @param float $price
   * @param DateTime $bookedAt
   * @param AssetCategory $category
   */
  public function __construct(int $id, string $name, float $price, DateTime $bookedAt, AssetCategory $category)
  {
    $this->id = $id;
    $this->name = $name;
    $this->price = $price;
    $this->bookedAt = $bookedAt;
    $this->category = $category;
  }

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
   * @return DateTime
   */
  public function getBookedAt(): DateTime
  {
    return $this->bookedAt;
  }

  /**
   * @return AssetCategory
   */
  public function getCategory(): AssetCategory
  {
    return $this->category;
  }

  /**
   * @return int
   */
  public function getDepreciationMonthCount(): int
  {
    return $this->category->getUsefulLife() * 12;
  }

  /**
   * calculate depreciation amount per month, use simple rounding
   * 
   * @return float
   */
  public function getMonthlyDepreciation(): float
  {
    return round($this->price / $this->getDepreciationMonthCount(), 2);
  }

  /**
   * since we are using simple rounding, there might be a difference between the total depreciation amount and the original price
   * this amount can be added either to the first or the last month's depreciation amount
   * 
   * @return float
   */
  public function getDepreciationAmountDifference(): float
  {
    return round($this->price - $this->getMonthlyDepreciation() * $this->getDepreciationMonthCount(), 2);
  }

  /**
   * @return array
   */
  public function __serialize(): array
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'price' => $this->price,
      'bookedAt' => $this->bookedAt->format('Y-m-d H:i:s'),
      'category' => $this->category->__serialize(),
      'monthlyDepreciation' => $this->getMonthlyDepreciation()
    ];
  }
}