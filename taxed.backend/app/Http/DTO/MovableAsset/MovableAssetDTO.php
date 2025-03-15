<?php

namespace App\Http\DTO\MovableAsset;

use App\Entity\DepreciationPeriod;
use App\Entity\MovableAsset;
use DateTime;
use NumberFormatter;

class MovableAssetDTO
{
  /**
   * @var int
   */
  public int $id;

  /**
   * @var string
   */
  public string $name;

  /**
   * @var float
   */
  public float $price;

  /**
   * @var string
   */
  public string $priceFormatted;

  /**
   * @var string
   */
  public string $bookedAt;

  /**
   * @var float
   */
  public float $monthlyDepreciation;

  /**
   * @var string
   */
  public string $monthlyDepreciationFormatted;

  /**
   * @var AssetCategoryDTO
   */
  public AssetCategoryDTO $category;

  /**
   * @return ?DepreciationPeriodDTO[]
   */
  public ?array $depreciationPeriods;

  /**
   * @param MovableAsset $entity
   * @param ?DepreciationPeriod[] $depreciationPeriods
   * 
   * @return void
   */
  public static function fromEntity(MovableAsset $entity, ?array $depreciationPeriods = null): self
  {
    $formatter = new NumberFormatter('de_DE', NumberFormatter::CURRENCY);

    $dto = new self();
    $dto->id = $entity->getId();
    $dto->name = $entity->getName();
    $dto->price = $entity->getPrice();
    $dto->priceFormatted = $formatter->formatCurrency($entity->getPrice(), "EUR");
    $dto->bookedAt = $entity->getBookedAt()->format(DateTime::ATOM);

    $dto->category = AssetCategoryDTO::fromEntity($entity->getCategory());

    $dto->monthlyDepreciation = $entity->getMonthlyDepreciation();
    $dto->monthlyDepreciationFormatted = $formatter->formatCurrency($entity->getMonthlyDepreciation(), "EUR");

    if (isset($depreciationPeriods)) {
      /** @var DepreciationPeriod $period */
      foreach ($depreciationPeriods as $period) {
        $dto->depreciationPeriods[] = DepreciationPeriodDTO::fromEntity($period);
      }
    }

    return $dto;
  }
}