<?php

namespace App\Entity;

class AssetCategory
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
   * @param int $id
   * @param string $name
   * @param int $usefulLife
   * @param int $depreciationRate
   */
  public function __construct(int $id, string $name, int $usefulLife, int $depreciationRate)
  {
    $this->id = $id;
    $this->name = $name;
    $this->usefulLife = $usefulLife;
    $this->depreciationRate = $depreciationRate;
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
}