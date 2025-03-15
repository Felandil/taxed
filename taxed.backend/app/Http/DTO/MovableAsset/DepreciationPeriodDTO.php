<?php

namespace App\Http\DTO\MovableAsset;

use App\Entity\DepreciationPeriod;
use DateTime;
use NumberFormatter;

class DepreciationPeriodDTO
{
  /**
   * @var string
   */
  public string $period;

    /**
   * @var string
   */
  public string $startDate;

  /**
   * @var string
   */
  public string $endDate;

  /**
   * @var float
   */
  public float $depreciation;

  /**
   * @var string
   */
  public string $depreciationFormatted;

  /**
   * @param DepreciationPeriod $depreciationPeriod
   * 
   * @return void
   */
  public static function fromEntity(DepreciationPeriod $depreciationPeriod): DepreciationPeriodDTO
  {
    $formatter = new NumberFormatter( 'de_DE', NumberFormatter::CURRENCY);

    $dto = new self();
    $dto->startDate = $depreciationPeriod->getStartDate()->format(DateTime::ATOM);
    $dto->endDate = $depreciationPeriod->getEndDate()->format(DateTime::ATOM);
    $dto->depreciation = $depreciationPeriod->getDepreciation();
    $dto->depreciationFormatted = $formatter->formatCurrency($depreciationPeriod->getDepreciation(), "EUR");
    $dto->period = $depreciationPeriod->format();

    return $dto;
  }
}