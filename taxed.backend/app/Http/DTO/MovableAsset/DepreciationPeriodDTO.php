<?php

use App\Entity\DepreciationPeriod;

class DepreciationPeriodDTO
{
  /**
   * @var string
   */
  private string $period;

    /**
   * @var string
   */
  private string $startDate;

  /**
   * @var string
   */
  private string $endDate;

  /**
   * @var float
   */
  private float $depreciation;

    /**
   * @var string
   */
  private float $depreciationFormatted;

  /**
   * @return string
   */
  public function getPeriod(): string
  {
    return $this->period;
  }

  /**
   * @return string
   */
  public function getStartDate(): string
  {
    return $this->startDate;
  }

  /**
   * @return string
   */
  public function getEndDate(): string
  {
    return $this->endDate;
  }

  /**
   * @return float
   */
  public function getDepreciation(): float
  {
    return $this->depreciation;
  }

  /**
   * @return string
   */
  public function getDepreciationFormatted(): string  
  {
    return $this->depreciationFormatted;
  }

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