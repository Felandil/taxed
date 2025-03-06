<?php

namespace App\Services;

use App\Repository\Models\AssetCategory;
use App\Repository\Models\MovableAsset;

use Carbon\Carbon;

class DepreciationCalculator
{
  public static function calculateDepreciation(MovableAsset $asset)
  {
    $category = $asset->assetCategory();

    $totalMonths = $category->useful_life * 12;
    $monthlyDepreciation = $asset->price / $totalMonths;
    $monthlyDepreciation = round($monthlyDepreciation, 100);

    $purchaseDate = Carbon::parse($asset->bookedAt);
    $depreciationEnd = $purchaseDate->copy()->addMonths($totalMonths);

    // economy year: 01.10 - 30.09
    if ($purchaseDate->month >= 10) {
      $firstEconomyYearStart = Carbon::create($purchaseDate->year, 10, 1);
    } else {
      $firstEconomyYearStart = Carbon::create($purchaseDate->year - 1, 10, 1);
    }

    $depreciationPerYear = [];
    $currentEconomyYearStart = $firstEconomyYearStart->copy();
    $totalDepreciatedMonths = 0;

    // Schleife über alle Wirtschaftsjahre innerhalb der Abschreibungsperiode
    while ($currentEconomyYearStart->lessThanOrEqualTo($depreciationEnd)) {
      $economyYearStart = $currentEconomyYearStart->copy();
      $economyYearEnd = $currentEconomyYearStart->copy()->addYear()->subDay(); // 30.09 des Folgejahres

      // Bestimme den tatsächlichen Zeitraum innerhalb des Wirtschaftsjahres, der abgeschrieben wird:
      $periodStart = $purchaseDate->greaterThan($economyYearStart) ? $purchaseDate->copy() : $economyYearStart->copy();
      $periodEnd = $depreciationEnd->lessThan($economyYearEnd) ? $depreciationEnd->copy() : $economyYearEnd->copy();

      if ($periodStart->greaterThan($periodEnd)) {
        $currentEconomyYearStart->addYear();
        continue;
      }

      // Berechne die Anzahl der Monate in diesem Zeitraum.
      // Wir runden die Differenz, und wenn 0 herauskommt, wird mindestens 1 Monat angesetzt.
      $months = round($periodStart->diffInMonths($periodEnd), 0);
      if ($months == 0) {
        $months = 1;
      }

      // Für das erste Wirtschaftsjahr: Nutze den Zeitraum vom Kaufdatum bis zum Ende des Wirtschaftsjahres.
      // Für nachfolgende Wirtschaftsjahre gilt: 12 Monate, außer im letzten Jahr.
      if ($economyYearStart->equalTo($firstEconomyYearStart)) {
        // Anzahl Monate im ersten Wirtschaftsjahr = Differenz vom Kaufdatum bis zum Ende des Wirtschaftsjahres + 1
        $months = round($purchaseDate->diffInMonths($economyYearEnd) + 1, 0);
      } else {
        // Falls es das letzte Wirtschaftsjahr ist, in dem weniger als 12 Monate verbleiben:
        $remaining = $totalMonths - $totalDepreciatedMonths;
        if ($remaining < 12) {
          $months = $remaining;
        } else {
          $months = 12;
        }
      }

      $totalDepreciatedMonths += $months;
      $yearDepreciation = round($monthlyDepreciation * $months, 2);
      $depreciationPerYear[] = [
        'period' => $economyYearStart->format('d.m.Y') . '-' . $economyYearEnd->format('d.m.Y'),
        'depreciation' => $yearDepreciation
      ];

      $currentEconomyYearStart->addYear();
    }

    $sum = array_reduce($depreciationPerYear, function ($carry, $item) {
      return $carry + $item['depreciation'];
  }, 0);

    $result = new \stdClass();
    $result->depreciationPerMonth = round($monthlyDepreciation, 2);
    $result->depreciationPerYear = $depreciationPerYear;

    return $result;
  }
}