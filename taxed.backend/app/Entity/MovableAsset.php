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
    ];
  }
}