<?php

namespace App\Services;

use App\Entity\MovableAsset;
use App\Entity\DepreciationPeriod;

use Carbon\Carbon;

class DepreciationCalculator implements IDepreciationCalculator
{
  /**
   * @var Carbon
   */
  private $economyYearStart;

  /**
   * @var Carbon
   */
  private $economyYearEnd;

  /**
   * @param Carbon $economyYearStart
   * @param Carbon $economyYearEnd
   */
  public function __construct(Carbon $economyYearStart, Carbon $economyYearEnd)
  {
    $this->economyYearStart = $economyYearStart;
    $this->economyYearEnd = $economyYearEnd;
  }

  /**
   * @param MovableAsset $asset
   * 
   * @return DepreciationPeriod[]
   */
  public function calculateDepreciation(MovableAsset $asset): array
  {
    $purchaseDate = Carbon::parse($asset->getBookedAt());
    $totalMonths = $asset->getDepreciationMonthCount();

    // determine the first economy year that the asset is part of
    if ($purchaseDate->month >= $this->economyYearStart->month) {
      $firstEconomyYearStart = Carbon::create($purchaseDate->year, $this->economyYearStart->month, 1);
    } else {
      $firstEconomyYearStart = Carbon::create($purchaseDate->year - 1, $this->economyYearStart->month, 1);
    }

    $depreciationPerYear = [];
    $currentEconomyYearStart = $firstEconomyYearStart->copy();
    $totalDepreciatedMonths = 0;

    // loop all years within the depreciation period until all month are depreciated
    while ($totalDepreciatedMonths < $asset->getDepreciationMonthCount()) {
      $economyYearStart = $currentEconomyYearStart->copy();
      $economyYearEnd = $currentEconomyYearStart->copy()->addYear()->subDay();

      // for the first economy year, the amount of months is the difference between the purchase date and the end of the economy year + 1
      // for following years, the amount of months is 12, unless it is the last economy year, where the amount of months is the remaining months
      if ($economyYearStart->equalTo($firstEconomyYearStart)) {
        $months = round($purchaseDate->diffInMonths($economyYearEnd) + 1, 0);
        if ($months > 12) {
          $months = 12;
        }
      } else {
        $remaining = $totalMonths - $totalDepreciatedMonths;
        $months = $remaining < 12 ? $remaining : 12;
      }

      // prepare next loop
      $currentEconomyYearStart->addYear();
      $totalDepreciatedMonths += $months;

      // calculate the depreciation amount for this period
      // if the asset is fully depreciated, add the remaining amount to the last period
      $depreciation = $asset->getMonthlyDepreciation() * $months;
      if ($totalDepreciatedMonths >= $asset->getDepreciationMonthCount()) {
        $depreciation += $asset->getDepreciationAmountDifference();
      } 

      array_push($depreciationPerYear, new DepreciationPeriod(
        $economyYearStart->toDate(), 
        $economyYearEnd->toDate(), 
        $depreciation
      ));
    }

    return $depreciationPerYear;
  }
}