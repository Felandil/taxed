<?php

namespace App\Usecase;

abstract class UsecaseResponse
{
  public static int $CodeSuccess = 1;
  public static int $CodeInvalidAssetCategory = -1;
  public static int $CodeInvalidAssetName = -2;
  public static int $CodeInvalidAssetPrice = -3;
  public static int $CodeUnknownError = -3;
  public int $code;

  /**
   * @param int $code
   */
  public function __construct(int $code)
  {
    $this->code = $code;
  }
}