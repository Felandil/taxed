<?php

namespace App\Entity;

use DateTime;

class DepreciationPeriod
{
  /**
   * @var DateTime
   */
  private DateTime $startDate;

  /**
   * @var DateTime
   */
  private DateTime $endDate;

  /**
   * @var float
   */
  private float $depreciation;

  /**
   * @param \DateTime $startDate
   * @param \DateTime $endDate
   * @param float $depreciation
   */
  public function __construct(DateTime $startDate, DateTime $endDate, float $depreciation)
  {
    $this->startDate = $startDate;
    $this->endDate = $endDate;
    $this->depreciation = $depreciation;
  }

  /**
   * @return DateTime
   */
  public function getStartDate(): DateTime
  {
    return $this->startDate;
  }

  /**
   * @return DateTime
   */
  public function getEndDate(): DateTime
  {
    return $this->endDate;
  } 

  /**
   * @return float
   */
  public function getDepreciation(): Float
  {
    return $this->depreciation;
  }

  /**
   * @return string
   */
  public function getDepreciationPeriod() :string
  {
    return $this->startDate->format('d.m.Y') . '-' . $this->endDate->format('d.m.Y');
  }
}