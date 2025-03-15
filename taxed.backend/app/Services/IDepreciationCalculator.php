<?php

namespace App\Services;

use App\Entity\MovableAsset;
use App\Entity\DepreciationPeriod;

interface IDepreciationCalculator
{
    /**
   * @param MovableAsset $asset
   * 
   * @return DepreciationPeriod[]
   */
  public function calculateDepreciation(MovableAsset $asset): array;
}